<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthAndAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Crear usuario administrador para pruebas
        User::create([
            'name' => 'Admin Test',
            'email' => 'admin@aydtaxi.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Crear usuario pasajero (normal) para pruebas
        User::create([
            'name' => 'Pasajero Test',
            'email' => 'pasajero@aydtaxi.com',
            'password' => Hash::make('password123'),
            'role' => 'pasajero',
        ]);
    }

    /**
     * Prueba 1: Login correcto -> Acceso permitido
     */
    public function test_01_login_correcto(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@aydtaxi.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();

        // Al seguir la redirección, da status 200
        $this->followRedirects($response)->assertStatus(200);
    }

    /**
     * Prueba 2: Password incorrecta -> Acceso rechazado
     */
    public function test_02_password_incorrecta(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@aydtaxi.com',
            'password' => 'clave_erronea',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Prueba 3: Usuario inexistente -> Acceso rechazado
     */
    public function test_03_usuario_inexistente(): void
    {
        $response = $this->post('/login', [
            'email' => 'noexiste@aydtaxi.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Prueba 4: Campos vacíos -> Validación
     */
    public function test_04_campos_vacios(): void
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => '',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email', 'password']);
        $this->assertGuest();
    }

    /**
     * Prueba 5: Registro correcto -> Usuario creado
     */
    public function test_05_registro_correcto(): void
    {
        $response = $this->post('/register', [
            'name' => 'Nuevo Conductor',
            'email' => 'nuevo.conductor@aydtaxi.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'conductor',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'email' => 'nuevo.conductor@aydtaxi.com',
            'role' => 'conductor',
        ]);
        $this->assertAuthenticated();
    }

    /**
     * Prueba 6: Correo duplicado -> Registro rechazado
     */
    public function test_06_correo_duplicado(): void
    {
        $response = $this->post('/register', [
            'name' => 'Duplicado User',
            'email' => 'admin@aydtaxi.com', // Ya existe en la BD
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'pasajero',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }

    /**
     * Prueba 7: Dashboard sin autenticación -> Acceso rechazado
     */
    public function test_07_dashboard_sin_autenticacion(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    /**
     * Prueba 8: Usuario normal -> administración -> Acceso rechazado
     */
    public function test_08_usuario_normal_a_administracion(): void
    {
        $pasajero = User::where('email', 'pasajero@aydtaxi.com')->first();

        $response = $this->actingAs($pasajero)->get('/admin/dashboard');

        // Debería retornar 403 Forbidden por el middleware de rol
        $response->assertStatus(403);
    }
}
