<?php
namespace App\Api\Controllers;

use App\Api\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Dingo\Api\Http\Request;

class AuthenticateController extends Controller
{
    /**
     * @SWG\Get(
     *     path="/api/v1/auth",
     *     tags={"auth"},
     *     summary="获取访问token",
     *     description="获取访问token",
     *     @SWG\Parameter(
     *         description="用户邮箱",
     *         in="query",
     *         name="email",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         description="用户密码",
     *         in="query",
     *         name="password",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation"
     *     )
     * )
     */
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return $this->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return $this->json(compact('token'));
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/refresh",
     *     tags={"auth"},
     *     summary="刷新访问token",
     *     description="刷新访问token",
     *     @SWG\Parameter(
     *         description="访问token",
     *         in="query",
     *         name="token",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation"
     *     )
     * )
     */
    public function refresh(Request $request)
    {
        $old_token = $request->get('token');
        $new_token = JWTAuth::refresh($old_token);
        return $this->json(compact('new_token'));
    }
}