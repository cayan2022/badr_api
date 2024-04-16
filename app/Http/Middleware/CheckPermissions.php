<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 *
 */
class CheckPermissions
{
    /**
     * @param  Request  $request
     * @param  Closure  $next
     * @return $this|mixed
     */
    public function handle(Request $request, Closure $next)
    {
//        $authGuard = app('auth')->guard('sanctum');
//
//        $exception = static fn($msg) => response()->json(['message' => $msg], 403);
//
//        if ($authGuard->guest()) {
//            return $exception(trans('auth.errors.not_login'));
//        }
//
//        $route = request()->route()->getName();
//
//        if (!is_string($route)) {
//            return $exception(trans('auth.errors.wrong_route'));
//        }
//
//        $routeNameToArray = explode('.', $route);
//
//        $route =  array_splice($routeNameToArray, -2);
//
//        /** uncomment next line if you need to clear permissions,roles cache
//         * | ex: when you change via database directly
//         * | app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
//         */
//
//        if (in_array($route[1], ['store', 'destroy'])) {
//            $name=$route[1]==="destroy"?'delete':'create';
//            if ($authGuard->user()->hasPermissionTo($name." ".$route[0], 'api')) {
//                return $next($request);
//            }
//            return $exception(trans('auth.errors.has_no_permission'));
//        }

        return $next($request);
    }
}
