<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRol
{
    /**
     * Permite el paso solo a usuarios activos cuyo rol esté en la lista (rol:1,2).
     * Si el rol no corresponde, se le envía a su propia área.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $usuario = $request->user();

        if (! $usuario || ! $usuario->Estado) {
            abort(403);
        }

        if (! in_array((string) $usuario->IdRol, $roles, true)) {
            if ($request->expectsJson()) {
                abort(403, 'No tienes permiso para esta acción.');
            }

            return redirect()->to($usuario->rutaInicio());
        }

        return $next($request);
    }
}
