<?php

namespace App\Transformers;

class UsersTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id'                    => $item['id'],
            'fullname'              => $item['name'],
            'email'                 => $item['email'],
            'status'                => $item['status'],
            'created_at'            => $item['created_at']
        ];
    }
}
