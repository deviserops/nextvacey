<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\Common;
use App\Http\Requests\Api\V1\RequestLogin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Api\ApiController;

class AuthController extends ApiController {

    public function requestLogin(RequestLogin $request) {
        $email = request()->post('email');
        $user = User::where(['email' => $email])->first();
        if (!$user) {
            return $this->returnResponse(false, 422, 'Invalid Email Provided.');
        }
        $mailToken = Str::random(80);
        $user->api_token = null;
        $user->hash_token = $mailToken;
        $user->update();
        $mailData = [
            'loginUrl' => env('PORTAL_URL') . '/request-login/' . $mailToken . '/' . $email,
        ];
        $loginMail = Common::sendMail($email, 'Login', $mailData, 'mail.requestLogin');
        if (!$loginMail) {
            return $this->returnResponse(false, 422, 'Problem with sending mail, Please try again.');
        }
        return $this->returnResponse(true, 200, 'Login Url has been send to your mail.');
    }

    public function userLogin(Request $request) {
        $credential = [
            'email' => request()->input('email'),
            'hash_token' => request()->input('token'),
        ];
        $getUser = User::where($credential)->first();
        if ($getUser && auth()->loginUsingId($getUser->id)) {
            // Authentication passed...
            /*Check if email is verified*/
            if ($this->resendVerificationMail($request)) {
                auth()->logout();
                return $this->returnResponse(false, 401, 'Email not verified. Please check your email.');
            }
            $user = auth()->user();
            $user->api_token = Str::random(80);
            $user->hash_token = null;
            $user->save();
            return $this->returnResponse(true, 200, 'Login Success.', $user);
        }
        return $this->returnResponse(false, 401, 'Unauthenticated', $credential);
    }

    public function resendVerificationMail($request) {
        return false; // comment this line to check email validation
        if ($request->user()->hasVerifiedEmail()) {
            return false;
        }
        $request->user()->sendEmailVerificationNotification();
        return true;
    }

    public function logout() {
        $authId = auth()->id();
        User::where(['id' => $authId])->update(['hash_token' => null, 'api_token' => null]);
        return $this->returnResponse(true, 200, 'Logged Out');
    }

    public function profile() {
        return $this->returnResponse(true, 200, 'This is user details', auth()->user());
    }

}
