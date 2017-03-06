<?php

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->group(['prefix' => 'v1', 'namespace' => 'App\Api\Controllers'], function ($api) {
        $api->get('auth', 'AuthenticateController@authenticate');
        $api->get('refresh', 'AuthenticateController@refresh');
        $api->get('token', function () {
            return new \Illuminate\Http\JsonResponse(array('token' => JWTAuth::getToken()));
        });
        
        $api->group(['middleware' => 'jwt.auth'], function ($api) {
            $api->get('users', 'UserController@index');
        });
    });
});

