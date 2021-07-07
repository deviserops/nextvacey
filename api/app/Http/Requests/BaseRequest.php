<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class BaseRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     *
     * @param Validator $validator This is use to rewrite the error for
     *                  Api only based on the header type application/json otherwise
     *                  this will return simple error same as before
     * @throws type
     */
    protected function failedValidation(Validator $validator) {
        /**
         *
         * Warning: Don't use this for Backend, Because if you do you
         *          will not receive required error format
         *
         */
        $getHeaders = getAllHeaders();
        $response = null;
        if (isset($getHeaders['Accept']) && (strtolower($getHeaders['Accept']) == 'application/json')) {
            $errorData = [
                'status' => false,
                'message' => 'Invalid Input Data',
                'data' => []
            ];
            $headers = [];
            $options = 0;
            if ($validator->errors() && $validator->errors()->messages() && count($validator->errors()->messages())) {
                $errorDetails = [];
                foreach ($validator->errors()->messages() as $key => $val) {
                    $errorDetails[$key] = isset($val[0]) ? $val[0] : 'Please fix error for ' . $key;
                }
                $errorData['data'] = $errorDetails;
            }
            $response = response()->json($errorData, 422, $headers, $options);
        }
        throw (new ValidationException($validator, $response))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }


}
