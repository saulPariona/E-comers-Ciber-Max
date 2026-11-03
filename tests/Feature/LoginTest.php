<?php

namespace Tests\Feature;

use App\Models\Usuario;
use Database\Seeders\RolSeeder;
use Database\Seeders\UsuarioSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([RolSeeder::class, UsuarioSeeder::class]);
    }

    public static function destinos(): array
    {
        return [
            'administrador' => ['admin@cibermax.test', '/admin'],
            'supervisor de ventas' => ['supervisor.ventas@cibermax.test', '/ventas'],
            'vendedor' => ['vendedor@cibermax.test', '/ventas'],
            'supervisor de almacén' => ['supervisor.almacen@cibermax.test', '/almacen'],
            'almacenero' => ['almacenero@cibermax.test', '/almacen'],
            'cliente' => ['cliente@cibermax.test', '/'],
        ];
    }

    #[DataProvider('destinos')]
    public function test_cada_rol_es_redirigido_a_su_area(string $email, string $ruta): void
    {
        $this->post('/login', ['email' => $email, 'password' => 'password'])
            ->assertRedirect($ruta);

        $this->assertAuthenticated();
    }

    public function test_credenciales_incorrectas_no_inician_sesion(): void
    {
        $this->from('/login')
            ->post('/login', ['email' => 'admin@cibermax.test', 'password' => 'mala'])
            ->assertRedirect('/login')
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_usuario_inactivo_no_puede_entrar(): void
    {
        Usuario::where('Email', 'cliente@cibermax.test')->update(['Estado' => false]);

        $this->post('/login', ['email' => 'cliente@cibermax.test', 'password' => 'password'])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_un_rol_no_entra_al_area_de_otro(): void
    {
        $vendedor = Usuario::where('Email', 'vendedor@cibermax.test')->first();

        $this->actingAs($vendedor)->get('/admin')->assertRedirect('/ventas');
        $this->actingAs($vendedor)->get('/almacen')->assertRedirect('/ventas');
        $this->actingAs($vendedor)->get('/ventas')->assertOk();
    }

    public function test_invitado_es_enviado_al_login(): void
    {
        $this->get('/admin')->assertRedirect('/login');
    }

    public function test_usuario_autenticado_no_ve_el_login(): void
    {
        $cliente = Usuario::where('Email', 'cliente@cibermax.test')->first();

        $this->actingAs($cliente)->get('/login')->assertRedirect('/');
    }

    public function test_registro_crea_cliente_y_abre_sesion(): void
    {
        $this->post('/registro', [
            'TipoDocumento' => 'DNI',
            'NumeroDocumento' => 70112233,
            'Nombres' => 'Ana',
            'Apellidos' => 'Lopez',
            'Email' => 'ana@example.com',
            'Password' => 'secreto123',
            'Password_confirmation' => 'secreto123',
        ])->assertRedirect('/');

        $this->assertAuthenticated();
        $this->assertDatabaseHas('clientes', ['IdUsuario' => Usuario::where('Email', 'ana@example.com')->value('IdUsuario')]);
    }

    public function test_la_api_interna_exige_ser_administrador(): void
    {
        $this->getJson('/api/v1/roles')->assertUnauthorized();

        $vendedor = Usuario::where('Email', 'vendedor@cibermax.test')->first();
        $this->actingAs($vendedor, 'sanctum')->getJson('/api/v1/roles')->assertForbidden();

        $admin = Usuario::where('Email', 'admin@cibermax.test')->first();
        $this->actingAs($admin, 'sanctum')->getJson('/api/v1/roles')->assertOk();
    }

    public function test_logout_cierra_la_sesion(): void
    {
        $cliente = Usuario::where('Email', 'cliente@cibermax.test')->first();

        $this->actingAs($cliente)->post('/logout')->assertRedirect('/');
        $this->assertGuest();
    }
}
