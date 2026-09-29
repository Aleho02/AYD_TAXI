<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! $request->user()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login');
        }

        if (! in_array($request->user()->role, $roles, true)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Acceso denegado: No tiene permisos suficientes para realizar esta acción.',
                    'required_roles' => $roles,
                    'current_role' => $request->user()->role,
                ], 403);
            }

            abort(403, 'Acceso denegado: No tiene permisos para acceder a esta sección del CMS.');
        }

        return $next($request);
    }
}
