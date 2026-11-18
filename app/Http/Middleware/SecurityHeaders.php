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

        // Restricción de permisos del navegador (permitir geolocalización para GPS en tiempo real)
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=*');

        // Content Security Policy (Z01): solo se permiten los orígenes que usa el CMS
        $response->headers->set('Content-Security-Policy', implode('; ', [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' https://unpkg.com",
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://fonts.bunny.net https://cdn.jsdelivr.net https://unpkg.com",
            "font-src 'self' data: https://fonts.gstatic.com https://fonts.bunny.net https://cdn.jsdelivr.net",
            "img-src 'self' data: blob: https://*.tile.openstreetmap.org https://mt1.google.com https://unpkg.com",
            "connect-src 'self' https://nominatim.openstreetmap.org https://router.project-osrm.org",
            "frame-ancestors 'self'",
            "form-action 'self'",
            "base-uri 'self'",
            "object-src 'none'",
        ]));

        // Eliminar información del servidor si estuviese presente
        $response->headers->remove('X-Powered-By');
        if (function_exists('header_remove')) {
            header_remove('X-Powered-By');
        }

        return $response;
    }
}
