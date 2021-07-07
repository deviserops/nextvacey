<?php

namespace App\Http\Controllers\Auth;

use App\Helper\ApiCall;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Facade\FlareClient\Api;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request) {
        $email = request()->post('email');
        $data = ApiCall::post('request-login', ['email' => $email]);
        if ($data['message']) {
            session()->put('info', $data['message']);
        }
        return redirect()->route('login');
    }

    public function requestLogin() {
        $data = [
            'token' => request()->route('token'),
            'email' => request()->route('email')
        ];
        $data = ApiCall::post('user-login', $data);
        if (!$data['status']) {
            session()->remove('authenticated');
            return redirect()->route('login');
        }
        session()->put('authenticated', $data['data']);
        return redirect()->route('home');
    }

    public function logout(Request $request) {
        ApiCall::post('logout');
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        if ($response = $this->loggedOut($request)) {
            return $response;
        }
        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

}
