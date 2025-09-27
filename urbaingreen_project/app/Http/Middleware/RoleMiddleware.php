<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Vérifier si l'utilisateur a le rôle requis
        if (!$user->hasRole($role)) {
            // Si c'est un admin, il peut accéder à tout
            if ($user->isAdmin()) {
                return $next($request);
            }

            // Sinon, rediriger selon le rôle de l'utilisateur
            if ($user->isChefProjet()) {
                return redirect()->route('admin.dashboard')->with('error', 'Accès non autorisé.');
            }

            return redirect()->route('public.home')->with('error', 'Accès non autorisé.');
        }

        return $next($request);
    }
}
