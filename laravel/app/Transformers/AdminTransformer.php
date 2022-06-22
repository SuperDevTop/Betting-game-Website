<?php

namespace App\Transformers;

class AdminTransformer extends Transformer
{
    public function transform($item)
    {
        $inrole=$this->roleName($item->roles->toArray());
        return [
            'id'          => $item->id,
            'name'        => $item->name,
            'email'       => $item->email,
            'status'      => $item->status,
            'designation' => $item->designation,
            'inrole'      => count($inrole) >0 ?$inrole[0]:'',
        ];
    }

    public function roleName($roles)
    {
        $inRoles = [];
        if (count($roles) > 0) {
            foreach ($roles as $role) {
                $inRoles[] = $role['name'];
            }
        }
        return $inRoles;
    }

    public function single($item)
    {
        return [
            'id'     => $item['id'],
            'name'   => $item['name'],
            'email'  => $item['email'],
            'status' => $item['status'],
            'inrole' => $this->roleName($item['roles'])
        ];
    }
}
