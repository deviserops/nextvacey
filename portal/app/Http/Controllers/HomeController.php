<?php

namespace App\Http\Controllers;

use App\Helper\ApiCall;
use App\Http\Requests\ChangeEmail;
use Illuminate\Http\Request;

class HomeController extends Controller {

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $profile = ApiCall::get('profile');
        return view('home', compact('profile'));
    }

    public function changeEmail() {
        return view('profile.changeEmail');
    }

    public function changeEmailSubmit(Request $request) {
        $email = request()->input('email');
        $response = ApiCall::post('change-email', ['email' => $email]);
        if (!$response['status']) {
            session()->put('warning', $response['message']);
            return redirect()->route('changeEmail');
        }
        /**
         * Logout User
         */
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        session()->put('success', $response['message']);
        ApiCall::post('logout');
        return redirect()->route('login');
    }
}
