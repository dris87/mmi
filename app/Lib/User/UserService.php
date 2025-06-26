<?php

namespace App\Lib\User;

use App\Models\User;

class UserService
{
    public function __construct(
        User $model
    ) {
        $this->model = $model;
    }

    public function createFromRequest($request)
    {
        $data = array_filter($request->only($this->model->getFillable()));

        return User::create($data);
    }
}
