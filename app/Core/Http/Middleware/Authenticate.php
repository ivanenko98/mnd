<?php

namespace App\Core\Http\Middleware;

use App\Dwolla\Model\Source\DwollaUserStatus;
use App\Users\Model\Source\Type;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class Authenticate extends Middleware
{

    protected $guards = [Type::ASSIGNOR, Type::REFEREE, Type::ASSIGNOR . '_api', Type::REFEREE . '_api', 'web'];

    public function handle($request, Closure $next, ...$guards)
    {
        if (empty($guards)) {
            $guards = $this->guards;
        }
        $this->authenticate($request, $guards);
        if (Auth::user()->getDwollaStatus() == DwollaUserStatus::SUSPENDED) {
            return Redirect::route('login', ['suspended' => true]);
        }
        if (Auth::user()->two_factor_enabled && !session("isVerified") && !$request->routeIs('verify')) {
            return \redirect('verify');
        }

        return $next($request);

    }

    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
