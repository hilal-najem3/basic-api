<?php

namespace App\Http\Middleware;

use Closure;

// This middleware allows admins to access the route
class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request  $request
     * @param \Closure  $next
     * @param $roles
     * @param $permission
     * @return mixed
     */
    public function handle($request, Closure $next, $roles = null, $permission = null)
    {
        $user = $request->user();

        if($user != null) {
            if(!$user->hasRole($roles)) {
                $error = [
                    'status' => 'error',
                    'message' => 'Access not allowed.'
                ];
                return response()->json($error, 405);
            }

            if($permission !== null && !$user->can($permission)) {
                $error = [
                    'status' => 'error',
                    'message' => 'Access not allowed.'
                ];
                return response()->json($error, 405);
            }

            return $next($request);
        }

        $error = [
            'status' => 'error',
            'message' => 'Access not allowed.'
        ];
        return response()->json($error, 405);
    }
}
