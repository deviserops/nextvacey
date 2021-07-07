<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
Route::fallback(function () {
    /**
     * for api custom page not found
     */
    $responseData = [
        'status' => false,
        'message' => 'Invalid url',
        'data' => (object)[]
    ];
    $headers = [];
    $options = 0;
    return response()->json($responseData, 404, $headers, $options);
});

$prefix = 'v1';
/**
 *
 * All Api without Authantication
 *
 */

Route::group(['prefix' => $prefix], function () {
    Route::post('request-login', [AuthController::class, 'requestLogin']);
    Route::post('user-login', [AuthController::class, 'userLogin']);
    Route::post('logout', [AuthController::class, 'logout']);
});

/**
 *
 * All Authorised Api Will Access Using This Group
 *
 */
Route::group(['middleware' => ['auth:api', 'apiAuth'], 'prefix' => $prefix], function () {
    Route::get('profile', [ProfileController::class, 'profile']);
    Route::post('change-email', [ProfileController::class, 'changeEmail']);
});
