<?php
namespace App\Api\Transformers;

class UserTransformer extends BaseTransformer
{

    public function transform($item)
    {
        return [
            'user_email' => $item['email'],
            'user_name' => $item['name']
        ];
    }
}