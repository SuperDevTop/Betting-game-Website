<?php

namespace App\Transformers;

class PermissionsTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id'    => $item['id'],
            'name'  => $item['name'],
            'label' => $item['label']
        ];
    }
}
