<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        /*$token = $request->header('token');
        $access = DB::table('personal_access_tokens')->where('token', '=', $token)->first();

        if ($access == null) {
            return response([
                'success' => false,
                'message' => 'No estás logueado.',
                'data' => []
            ], 401);
        }*/

        return $next($request);
    }
}
