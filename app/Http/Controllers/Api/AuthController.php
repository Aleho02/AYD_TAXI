<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetOtpMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Registro de usuario API
     */
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['nullable', 'in:admin,conductor,pasajero'],
            'phone' => ['nullable', 'string', 'max:20'],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo es inválido.',
            'email.unique' => 'El correo electrónico ya se encuentra registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'role.in' => 'El rol seleccionado no es válido.',
        ]);

        $role = $validated['role'] ?? 'pasajero';

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $role,
            'phone' => $validated['phone'] ?? null,
            'is_available' => $role === 'conductor',
        ]);

        $token = $user->createToken('api_auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Usuario registrado exitosamente en AYD TAXII.',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'phone' => $user->phone,
            ],
            'token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    /**
     * Login de usuario API
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'El correo es requerido.',
            'email.email' => 'Debe ingresar un correo válido.',
            'password.required' => 'La contraseña es requerida.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Credenciales inválidas. Verifique su correo o contraseña.',
            ], 401);
        }

        $token = $user->createToken('api_auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Inicio de sesión exitoso.',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'phone' => $user->phone,
                'license_number' => $user->license_number,
                'photo_url' => $user->photo_path ? asset('storage/' . $user->photo_path) : null,
            ],
            'token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }

    /**
     * Enviar código OTP de 6 dígitos al correo registrado (API)
     */
    public function sendResetCode(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar un correo electrónico válido.',
            'email.exists' => 'No existe ningún usuario registrado con este correo.',
        ]);

        $user = User::where('email', $validated['email'])->firstOrFail();
        $otpCode = (string) random_int(100000, 999999);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => Hash::make($otpCode),
                'created_at' => now(),
            ]
        );

        Mail::to($user->email)->send(new PasswordResetOtpMail($user, $otpCode));

        return response()->json([
            'status' => 'success',
            'message' => 'Se ha enviado el código OTP de 6 dígitos al correo ' . $user->email,
        ]);
    }

    /**
     * Verificar código OTP y actualizar contraseña (API)
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'otp_code' => ['required', 'digits:6'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $validated['email'])
            ->first();

        if (!$resetRecord || !Hash::check($validated['otp_code'], $resetRecord->token)) {
            return response()->json([
                'status' => 'error',
                'message' => 'El código OTP ingresado es inválido.',
            ], 422);
        }

        if ($resetRecord->created_at && Carbon::parse($resetRecord->created_at)->addMinutes(15)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $validated['email'])->delete();

            return response()->json([
                'status' => 'error',
                'message' => 'El código OTP ha expirado.',
            ], 422);
        }

        $user = User::where('email', $validated['email'])->firstOrFail();
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        DB::table('password_reset_tokens')->where('email', $validated['email'])->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Contraseña restablecida exitosamente.',
        ]);
    }

    /**
     * Perfil de usuario autenticado
     */
    public function profile(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'status' => 'success',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'phone' => $user->phone,
                'license_number' => $user->license_number,
                'is_available' => $user->is_available,
                'latitude' => $user->latitude,
                'longitude' => $user->longitude,
                'photo_url' => $user->photo_path ? asset('storage/' . $user->photo_path) : null,
                'vehicle' => $user->vehicle,
                'created_at' => $user->created_at,
            ],
        ], 200);
    }

    /**
     * Cierre de sesión API
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Sesión cerrada correctamente y token revocado.',
        ], 200);
    }
}
