<?php
/**
 * Created by PhpStorm.
 * User: juan.llusco
 * Date: 19/6/2024
 * Time: 18:53
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class CheckPermissions
{
    /**
     * Handle an incoming request.
     * @param Request $request
     * @param Closure $next
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return Response
     */
    public function handle(Request $request, Closure $next, $permissions): Response
    {
        $user = $request->user();
        if ($user->tokenCan($permissions)) {
            return $next($request);
        }
        return response()->json(['finalizado'=>false,'mensaje' => 'No autorizado'], 403);
    }
}