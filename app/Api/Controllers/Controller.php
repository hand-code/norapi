<?php
namespace App\Api\Controllers;

use Dingo\Api\Http\Response;

class Controller
{
    public function json($data, $code = 200)
    {
        return new Response($data, $code);
    }
}