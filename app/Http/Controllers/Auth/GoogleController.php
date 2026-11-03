<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request): RedirectResponse
    {
        try {
            $google = Socialite::driver('google')->user();
        } catch (Throwable) {
            return $this->falla('No pudimos iniciar sesión con Google. Inténtalo de nuevo.');
        }

        // Solo se confía en el correo si Google lo tiene verificado.
        if (! $google->getEmail() || ($google->user['email_verified'] ?? true) === false) {
            return $this->falla('Tu cuenta de Google no tiene un correo verificado.');
        }

        $usuario = Usuario::where('Google_id', $google->getId())->first()
            ?? Usuario::where('Email', strtolower($google->getEmail()))->first();

        if ($usuario) {
            if (! $usuario->Estado) {
                return $this->falla('Tu cuenta está desactivada. Contacta con soporte.');
            }

            $usuario->forceFill([
                'Google_id' => $usuario->Google_id ?? $google->getId(),
                'email_verified_at' => $usuario->email_verified_at ?? now(),
                'Foto' => $usuario->Foto ?? $google->getAvatar(),
            ])->save();
        } else {
            $usuario = Usuario::crearCliente([
                'Nombres' => $google->user['given_name'] ?? $google->getName() ?? 'Cliente',
                'Apellidos' => $google->user['family_name'] ?? '',
                'Email' => strtolower($google->getEmail()),
                'email_verified_at' => now(),
                'Google_id' => $google->getId(),
                'Foto' => $google->getAvatar(),
            ]);
        }

        Auth::login($usuario, remember: true);
        $request->session()->regenerate();

        return $usuario->esEmpleado()
            ? redirect()->to($usuario->rutaInicio())
            : redirect()->intended($usuario->rutaInicio());
    }

    private function falla(string $mensaje): RedirectResponse
    {
        return redirect()->route('login')->withErrors(['email' => $mensaje]);
    }
}
