<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = $request->input('id');

        if (is_numeric($id) || $id != (int)$id || $id <= 0) {
            return response([
                'success' => false,
                'message' => 'El id no es valido.',
                'data' => []
            ], 403);
        }

        return $next($request);
    }
}
