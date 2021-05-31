<?php

namespace App\Core\Http\Middleware;

use App\Portal\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $authUser = Auth::user();

        if ($authUser !== null) {
            $langSetting = Cache::remember('language', 60*60*24, function () use ($authUser) {
                return $authUser->settings()->title('language')->first();
            });

            if ($langSetting !== null) {
                app()->setLocale($langSetting->pivot->value);
            }
        }

        return $next($request);
    }
}
