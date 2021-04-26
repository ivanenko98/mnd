<?php

namespace App\Core\Http\Middleware;

//use App\Portal\Models\Source\Type;
//use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
//use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
//    protected $guards = [Type::MANAGER, Type::MASTER, Type::ADMIN, Type::MASTER . '_api'];
//
//    public function handle($request, Closure $next, ...$guards)
//    {
//        if (empty($guards)) {
//            $guards = $this->guards;
//        }
//        $this->authenticate($request, $guards);
//
////        if (Auth::user()->two_factor_enabled && !session("isVerified") && !$request->routeIs('verify')) {
////            return \redirect('verify');
////        }
//
//        return $next($request);
//    }
//
//    protected function redirectTo($request)
//    {
//        if (! $request->expectsJson()) {
//            return route('login');
//        }
//    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
