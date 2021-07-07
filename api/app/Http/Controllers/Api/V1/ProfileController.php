<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\Common;
use App\Http\Requests\Api\V1\ChangeEmail;
use App\Http\Requests\Api\V1\RequestLogin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Api\ApiController;

class ProfileController extends ApiController {

    public function profile() {
        return $this->returnResponse(true, 200, 'This is user details, Fetch from portal api.', auth()->user());
    }

    public function changeEmail(ChangeEmail $request) {
        $email = request()->input('email');
        $authId = auth()->id();
        User::where(['id' => $authId])->update(['email' => $email, 'hash_token' => null, 'api_token' => null]);
        return $this->returnResponse(true, 200, 'Mail Changed Successfully, Please login again.');
    }

}
