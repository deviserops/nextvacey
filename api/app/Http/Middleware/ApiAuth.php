<?php

namespace App\Http\Middleware;

use App\Helper\Common;
use App\Models\User;
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
        $getAllHeaders = getallheaders();
        $uuid = $getAllHeaders['uuid'];
        $token = explode(' ', $getAllHeaders['Authorization']);
        $token = end($token);
        $user = User::where(['uuid' => $uuid, 'api_token' => $token])->first();
        if (!$user) {
            User::where(['id' => auth()->id()])->update(['api_token' => null]);
            return Common::returnResponse(false, 401, 'Unauthenticated.');
        }
        return $next($request);
    }
}
