<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request and attach standard security headers.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Mitigación de Clickjacking (Z02)
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Mitigación MIME-sniffing (Z04)
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Política de referer estricta
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Restricción de permisos del navegador
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(self)');

        // Eliminar información del servidor si estuviese presente
        $response->headers->remove('X-Powered-By');
        if (function_exists('header_remove')) {
            header_remove('X-Powered-By');
        }

        return $response;
    }
}
