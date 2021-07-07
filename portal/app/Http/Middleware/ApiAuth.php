<?php

namespace App\Http\Middleware;

use Closure;

class ApiAuth {
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $authData = session()->get('authenticated');
        $apiToken = $authData['api_token'] ?? null;
        $uuid = $authData['uuid'] ?? null;
        if ($authData && $apiToken && $uuid) {
            view()->composer('*', function ($view) {
                $view->with('authUser', session()->get('authenticated'));
            });
            return $next($request);
        }
        return redirect()->route('login');
    }
}
