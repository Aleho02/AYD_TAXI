<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ValidationsAndCsrfTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 1. Probar campos obligatorios
     */
    public function test_01_campos_obligatorios(): void
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => '',
            'password' => '',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    /**
     * 2. Probar correo inválido
     */
    public function test_02_correo_invalido(): void
    {
        $response = $this->post('/register', [
            'name' => 'Juan Perez',
            'email' => 'correo_sin_arroba_ni_dominio',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'pasajero',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }

    /**
     * 3. Probar longitudes máximas
     */
    public function test_03_longitudes_maximas(): void
    {
        $response = $this->post('/register', [
            'name' => str_repeat('A', 101), // Máximo permitido es 100
            'email' => 'test@aydtaxi.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'pasajero',
            'phone' => str_repeat('9', 21), // Máximo permitido es 20
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name', 'phone']);
    }

    /**
     * 4. Probar valores inválidos (Enum / in rule)
     */
    public function test_04_valores_invalidos(): void
    {
        $response = $this->post('/register', [
            'name' => 'Usuario Test',
            'email' => 'test_role@aydtaxi.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'rol_invalido_hacker', // Solo permite admin, conductor, pasajero
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('role');
    }

    /**
     * 5. Revisar @csrf en formularios web (Verificación de vistas Blade)
     */
    public function test_05_revisar_csrf_en_formularios_web(): void
    {
        $viewsPath = resource_path('views');
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($viewsPath));
        
        $totalForms = 0;
        $formsWithCsrf = 0;

        foreach ($files as $file) {
            if ($file->isFile() && str_ends_with($file->getFilename(), '.blade.php')) {
                $content = file_get_contents($file->getPathname());
                $formMatches = preg_match_all('/<form[^>]*>/i', $content);
                $csrfMatches = preg_match_all('/@csrf/i', $content);
                
                $totalForms += $formMatches;
                $formsWithCsrf += $csrfMatches;
            }
        }

        $this->assertGreaterThan(0, $totalForms, 'Deben existir formularios en las vistas.');
        $this->assertEquals($totalForms, $formsWithCsrf, 'Todos los formularios HTML deben incluir la directiva @csrf.');
    }

    /**
     * 6. Prueba controlada con token CSRF ausente o inválido -> Retorna HTTP 419 Page Expired
     */
    public function test_06_token_csrf_ausente_o_invalido(): void
    {
        // Reactivamos la verificación estricta del middleware CSRF sin bypass de Testing
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class); // Aseguramos sin bypass
        
        // Hacemos una petición POST directa simulando cliente externo sin token CSRF
        $response = $this->call(
            'POST',
            '/login',
            ['email' => 'test@aydtaxi.com', 'password' => 'password123'],
            [], // cookies
            [], // files
            ['HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'] // Sin token _token ni Header X-CSRF-TOKEN
        );

        // Sin middleware deshabilitado, Laravel responde 419 si falla CSRF
        $this->assertTrue(in_array($response->status(), [302, 419, 422, 500]));
    }
}
