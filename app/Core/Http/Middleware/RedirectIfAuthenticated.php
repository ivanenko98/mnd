<?php

namespace App\Core\Http\Middleware;

use App\Users\Model\Source\Type;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $guards = [Type::ASSIGNOR, Type::REFEREE, Type::ASSIGNOR . '_api', Type::REFEREE . '_api', 'web'];

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::shouldUse($guard);
            }
        }
        if (Auth::check() && Auth::user()->verified == 1 && Auth::user()->two_factor_enabled) {
            if (\session('isVerified')) {
                return redirect()->route('dashboard');
            }
            return redirect('/verify');
        }

        return $next($request);
    }
}
