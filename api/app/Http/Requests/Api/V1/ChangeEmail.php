<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Requests\BaseRequest;

class ChangeEmail extends BaseRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'email' => 'required|unique:users,email,' . auth()->id()
        ];
    }

    public function messages() {
        return [
            'email.required' => 'please enter email'
        ];
    }
}
