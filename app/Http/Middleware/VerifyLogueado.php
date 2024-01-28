<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyLogueado
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $params = $request->validate([
            'remember_token' => 'required'
        ]);

        $user = User::where('remember_token', '=', $params['remember_token'])->first();

        if ($user == null) {
            return response([
                'success' => false,
                'message' => 'No estás logueado.',
                'data' => []
            ], 403);
        }

        return $next($request);
    }
}
