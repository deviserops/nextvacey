<?php

namespace App\Http\Controllers\Api;

use App\Helper\Common;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class ApiController extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    /**
     * @param $status This is required(true || false)
     * @param null $code Response Error Code or success code(EX: 400,200,401,422,500 etc.)
     * @param null $message This is to show message on error.
     * @param array $data If you want to send any return data with response
     * @param null $function This function will call in javascript like webCracker(param) (this is your custom function and param will be your data you send).
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function returnResponse($status, $code = null, $message = null, $data = [], $function = null) {
        return Common::returnResponse($status, $code, $message, $data, $function);
    }

}
