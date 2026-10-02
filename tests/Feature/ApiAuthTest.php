<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ApiAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Crear usuario base para pruebas
        User::create([
            'name' => 'Usuario Ejemplo',
            'email' => 'existente@aydtaxi.com',
            'password' => Hash::make('password123'),
            'role' => 'pasajero',
        ]);
    }

    /**
     * 1. POST /api/register - Datos válidos -> Usuario creado (201)
     */
    public function test_01_api_register_datos_validos(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Nuevo Usuario API',
            'email' => 'nuevoapi@aydtaxi.com',
            'password' => 'password123',
            'role' => 'pasajero',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['status', 'message', 'user', 'token', 'token_type']);
    }

    /**
     * 2. POST /api/register - Datos inválidos -> Validación (422)
     */
    public function test_02_api_register_datos_invalidos(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => '',
            'email' => 'correo_invalido',
            'password' => '123',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    /**
     * 3. POST /api/register - Correo duplicado -> Rechazado (422)
     */
    public function test_03_api_register_correo_duplicado(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Otro Usuario',
            'email' => 'existente@aydtaxi.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }

    /**
     * 4. POST /api/login - Credenciales válidas -> Autenticación (200)
     */
    public function test_04_api_login_credenciales_validas(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'existente@aydtaxi.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['status', 'message', 'user', 'token', 'token_type']);
    }

    /**
     * 5. POST /api/login - Credenciales inválidas -> Rechazado (401)
     */
    public function test_05_api_login_credenciales_invalidas(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'existente@aydtaxi.com',
            'password' => 'clave_erronea',
        ]);

        $response->assertStatus(401)
                 ->assertJson(['status' => 'error']);
    }

    /**
     * 6. GET /api/profile - Sin token -> Rechazado (401)
     */
    public function test_06_api_profile_sin_token(): void
    {
        $response = $this->getJson('/api/profile');

        $response->assertStatus(401);
    }

    /**
     * 7. GET /api/profile - Token válido -> Permitido (200)
     */
    public function test_07_api_profile_token_valido(): void
    {
        $user = User::where('email', 'existente@aydtaxi.com')->first();
        $token = $user->createToken('test_token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->getJson('/api/profile');

        $response->assertStatus(200)
                 ->assertJson(['status' => 'success']);
    }

    /**
     * 8. GET /api/profile - Token inválido -> Rechazado (401)
     */
    public function test_08_api_profile_token_invalido(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer token_falso_12345')
                         ->getJson('/api/profile');

        $response->assertStatus(401);
    }

    /**
     * 9. POST /api/logout - Token válido -> Cierre de sesión (200)
     */
    public function test_09_api_logout_token_valido(): void
    {
        $user = User::where('email', 'existente@aydtaxi.com')->first();
        $token = $user->createToken('test_token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->postJson('/api/logout');

        $response->assertStatus(200)
                 ->assertJson(['status' => 'success']);
    }
}
