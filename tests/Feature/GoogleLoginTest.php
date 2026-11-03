<?php

namespace Tests\Feature;

use App\Models\Usuario;
use Database\Seeders\RolSeeder;
use Database\Seeders\UsuarioSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as GoogleUser;
use Mockery;
use Tests\TestCase;

class GoogleLoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([RolSeeder::class, UsuarioSeeder::class]);
    }

    private function googleDevuelve(string $id, string $email, bool $verificado = true): void
    {
        $google = (new GoogleUser)->setRaw([
            'given_name' => 'Ana',
            'family_name' => 'Lopez',
            'email_verified' => $verificado,
        ])->map(['id' => $id, 'name' => 'Ana Lopez', 'email' => $email, 'avatar' => 'https://foto.test/a.png']);
        $google->user = ['given_name' => 'Ana', 'family_name' => 'Lopez', 'email_verified' => $verificado];

        $provider = Mockery::mock(Provider::class);
        $provider->shouldReceive('user')->andReturn($google);
        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);
    }

    public function test_redirige_a_google(): void
    {
        $this->get('/auth/google')->assertRedirectContains('accounts.google.com');
    }

    public function test_usuario_nuevo_se_crea_como_cliente(): void
    {
        $this->googleDevuelve('g-123', 'nueva@gmail.com');

        $this->get('/auth/google/callback')->assertRedirect('/');

        $usuario = Usuario::where('Email', 'nueva@gmail.com')->first();
        $this->assertNotNull($usuario);
        $this->assertSame('g-123', $usuario->Google_id);
        $this->assertSame(6, $usuario->IdRol);
        $this->assertNull($usuario->NumeroDocumento);
        $this->assertDatabaseHas('clientes', ['IdUsuario' => $usuario->IdUsuario]);
        $this->assertAuthenticatedAs($usuario);
    }

    public function test_cuenta_existente_se_vincula_por_correo(): void
    {
        $this->googleDevuelve('g-999', 'cliente@cibermax.test');

        $this->get('/auth/google/callback')->assertRedirect('/');

        $this->assertSame('g-999', Usuario::where('Email', 'cliente@cibermax.test')->value('Google_id'));
        $this->assertSame(1, Usuario::where('Email', 'cliente@cibermax.test')->count());
    }

    public function test_empleado_con_google_va_a_su_area(): void
    {
        $this->googleDevuelve('g-777', 'vendedor@cibermax.test');

        $this->get('/auth/google/callback')->assertRedirect('/ventas');
    }

    public function test_correo_no_verificado_es_rechazado(): void
    {
        $this->googleDevuelve('g-555', 'falso@gmail.com', verificado: false);

        $this->get('/auth/google/callback')->assertRedirect('/login')->assertSessionHasErrors('email');

        $this->assertGuest();
        $this->assertDatabaseMissing('usuarios', ['Email' => 'falso@gmail.com']);
    }

    public function test_usuario_inactivo_es_rechazado(): void
    {
        Usuario::where('Email', 'cliente@cibermax.test')->update(['Estado' => false]);
        $this->googleDevuelve('g-444', 'cliente@cibermax.test');

        $this->get('/auth/google/callback')->assertRedirect('/login')->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_cuenta_google_sin_contrasena_no_entra_con_formulario(): void
    {
        $this->googleDevuelve('g-333', 'solo@gmail.com');
        $this->get('/auth/google/callback');
        auth()->logout();

        $this->post('/login', ['email' => 'solo@gmail.com', 'password' => 'cualquiera'])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }
}
