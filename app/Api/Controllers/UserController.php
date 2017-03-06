<?php

namespace App\Api\Controllers;

use App\Api\Transformers\UserTransformer;
use App\User;

class UserController extends Controller
{
    protected $userTransformer;

    public function __construct(UserTransformer $userTransformer)
    {
        $this->userTransformer = $userTransformer;
    }

    /**
     * @SWG\Get(
     *     path="/api/v1/users",
     *     tags={"users"},
     *     summary="获取所有用户信息",
     *     description="获取所有用户信息",
     *     @SWG\Parameter(
     *         description="持有的token",
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
    public function index()
    {
        return $this->json(array('users' => $this->userTransformer->transformCollections(User::all())));
    }
}