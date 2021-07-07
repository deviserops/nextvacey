<?php

namespace App\Http\Requests;

class ChangeEmail extends BaseRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'email' => 'required'
        ];
    }

    public function messages() {
        return [
            'email.required' => 'please enter email'
        ];
    }
}
