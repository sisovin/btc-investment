<?php

namespace App\Middleware;

use App\Core\Auth;
use App\Core\Response;

class AuthMiddleware
{
    /**
     * Handle authentication middleware
     */
    public function handle($request, $next)
    {
        if (!Auth::check()) {
            if ($request->isAjax()) {
                $response = new Response();
                return $response->json(['error' => 'Unauthorized'], 401);
            }

            return redirect('/login');
        }

        return $next($request);
    }
}