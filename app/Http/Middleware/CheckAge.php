<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAge
{
    public function handle(Request $request, Closure $next): Response
    {
        $age = $request->query('age');

        if ($age !== null && $age < 18) {
            return redirect('/acces-refuse');
        }

        return $next($request);
    }
}
