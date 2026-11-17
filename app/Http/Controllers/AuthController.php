<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetOtpMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar un correo electrónico válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return $this->redirectByRole(Auth::user());
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function showRegister(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role' => ['required', 'in:admin,conductor,pasajero'],
            'phone' => ['nullable', 'string', 'max:20'],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar un formato de correo electrónico válido.',
            'email.unique' => 'El correo electrónico ya está registrado en el sistema.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'role.in' => 'El rol seleccionado no es válido.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'phone' => $validated['phone'] ?? null,
            'is_available' => $validated['role'] === 'conductor',
        ]);

        Auth::login($user);

        return $this->redirectByRole($user);
    }

    public function showForgotPassword(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Paso 1: Validar correo registrado, generar código OTP de 6 dígitos y enviarlo por correo electrónico
     */
    public function sendResetCode(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.required' => 'Por favor ingresa tu correo electrónico registrado.',
            'email.email' => 'Debes ingresar un formato de correo electrónico válido.',
            'email.exists' => 'No existe ningún usuario registrado con este correo electrónico en AYD TAXI.',
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

        try {
            Mail::to($user->email)->send(new PasswordResetOtpMail($user, $otpCode));
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'No se pudo conectar al servidor SMTP para enviar el correo (' . $e->getMessage() . '). Verifica las credenciales MAIL_USERNAME y MAIL_PASSWORD en el archivo .env.');
        }

        return back()
            ->with('otp_email', $user->email)
            ->with('success', '¡Código OTP de 6 dígitos enviado exitosamente al correo ' . $user->email . '! Revisa tu bandeja de entrada o carpeta de Spam.');
    }

    /**
     * Paso 2: Verificar el código OTP de 6 dígitos enviado al correo y actualizar la contraseña del usuario
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'otp_code' => ['required', 'digits:6'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'email.required' => 'Debes ingresar el correo electrónico registrado.',
            'email.email' => 'El formato del correo electrónico no es válido.',
            'email.exists' => 'Este correo electrónico no se encuentra registrado en el sistema.',
            'otp_code.required' => 'Debes ingresar el código OTP de 6 dígitos enviado a tu correo.',
            'otp_code.digits' => 'El código OTP debe tener exactamente 6 dígitos numéricos.',
            'password.required' => 'Debes ingresar la nueva contraseña.',
            'password.min' => 'La nueva contraseña debe tener al menos 6 caracteres.',
            'password.confirmed' => 'La confirmación de la nueva contraseña no coincide.',
        ]);

        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $validated['email'])
            ->first();

        if (!$resetRecord) {
            return back()
                ->withInput($request->only('email'))
                ->with('otp_email', $validated['email'])
                ->withErrors(['otp_code' => 'Primero debes solicitar el envío del código OTP a tu correo electrónico.']);
        }

        // Verificar expiración de 15 minutos
        if ($resetRecord->created_at && Carbon::parse($resetRecord->created_at)->addMinutes(15)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $validated['email'])->delete();

            return back()
                ->withInput($request->only('email'))
                ->with('otp_email', $validated['email'])
                ->withErrors(['otp_code' => 'El código OTP ha expirado (validez de 15 minutos). Solicita uno nuevo.']);
        }

        if (!Hash::check($validated['otp_code'], $resetRecord->token)) {
            return back()
                ->withInput($request->only('email'))
                ->with('otp_email', $validated['email'])
                ->withErrors(['otp_code' => 'El código OTP de 6 dígitos ingresado es incorrecto.']);
        }

        $user = User::where('email', $validated['email'])->firstOrFail();
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        DB::table('password_reset_tokens')->where('email', $validated['email'])->delete();

        return redirect()->route('login')
            ->with('success', '¡Contraseña restablecida exitosamente! Ya puedes iniciar sesión con tu nueva clave.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente.');
    }

    private function redirectByRole(User $user): RedirectResponse
    {
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isConductor()) {
            return redirect()->route('conductor.dashboard');
        } else {
            return redirect()->route('pasajero.dashboard');
        }
    }
}
