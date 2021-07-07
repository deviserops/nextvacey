<?php

namespace App\Helper;

use App\Mail\SendMail;
use Illuminate\Support\Facades\Log;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Common {


    /**
     * @param $status This is required(true || false)
     * @param null $code Response Error Code or success code(EX: 400,200,401,422,500 etc.)
     * @param null $message This is to show message on error.
     * @param array $data If you want to send any return data with response
     * @param null $function This function will call in javascript like hgphpdev(param) (this is your custom function and param will be your data you send).
     * @return array|\Illuminate\Http\JsonResponse
     */
    public static function returnResponse($status, $code = null, $message = null, $data = [], $function = null) {
        /** This will check header or any request call, So in api we request for applicaton/json. **/
        if (request()->wantsJson()) {
            $responseData = [
                'status' => $status,
                'message' => $message,
                'data' => ($data === []) ? (object)$data : $data
            ];
            $headers = [];
            $options = 0;
            $code = $code ?? 200;
            return response()->json($responseData, $code, $headers, $options);
        } else {
            return [
                'status' => $status,
                'message' => $message,
                'data' => $data,
                'function' => $function
            ];
        }
    }

    /**
     *
     * @param $inputDate
     * @param $inputFormat
     * @param string $outpurFormat
     * @param null $modifyCommand
     * @return type Default Output format will be "Y-m-d H:i:s".
     *
     * @h This is for 12 Hour
     * @H This os for 24 Hour
     * @m This is for month
     * @d This is for day
     * @Y This is for year
     * @a This is for 'am' and 'pm' ('AM' and 'PM' by Capital A (A))
     * @exanple input = '02:10:05 PM 2015-02-24'; output = '14:10:05 2015-10-05
     */
    public static function fixDateFormat($inputDate, $inputFormat, $outpurFormat = 'Y-m-d H:i:s', $modifyCommand = null) {
        if (($inputDate == '0000-00-00') || $inputDate == '00-00-0000') {
            return null;
        }
        if (!$inputDate || $inputDate == '') {
            return $inputDate;
        }
        $generateData = \DateTime::createFromFormat($inputFormat, $inputDate);
        if (!$generateData) {
            throw new \UnexpectedValueException("Invalid Date: $inputDate");
        }
        if ($modifyCommand) {
            $generateData->modify($modifyCommand);
        }
        $newDate = $generateData->format($outpurFormat);
        return $newDate;
    }

    /**
     * To send mail
     * @param string $to Mail address of the receiver
     * @param string $subject Subject of the mail
     * @param array()   $data       Data to send to view file
     * @param string $view File to be send as email
     */
    public static function sendMail($to, $subject, $data, $view) {
        try {
            \Mail::to($to)->send(new SendMail($subject, $data, $view));
            return true;
        } catch (\Exception $ex) {
            if (env('APP_DEBUG')) {
                Log::error($ex->getMessage());
            }
            return false;
        }
    }

}
