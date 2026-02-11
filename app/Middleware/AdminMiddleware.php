<?php

namespace App\Middleware;

use App\Core\Auth;
use App\Core\Response;

class AdminMiddleware
{
    /**
     * Handle admin authorization middleware
     */
    public function handle($request, $next)
    {
        $user = Auth::user();

        if (!$user || !$user->is_admin) {
            if ($request->isAjax()) {
                $response = new Response();
                return $response->json(['error' => 'Forbidden'], 403);
            }

            abort(403, 'Access denied');
        }

        return $next($request);
    }
}