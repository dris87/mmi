<?php

namespace App\Lib\User;

use App\Lib\Exceptions\Repository\RepositoryUpdateException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    private $model;

    public function __construct(
        User $model
    ) {
        $this->model = $model;
    }

    public function getById(int $id)
    {
        return User::where('id', $id)->first();
    }

    public function createFromRequest($request)
    {
        $data = array_filter($request->only($this->getFillable()));
        $data['password'] = Hash::make('123456'); //TODO DEFAULT PASSWORD
        $data['email_verified_at'] = now();
        return User::create($data);
    }

    /**
     * @throws RepositoryUpdateException
     */
    public function updateFromRequest(User $userModel, $request): User
    {
        $data = array_filter($request->only($this->getFillable()));

        if (!$userModel->update($data)) {
            throw new RepositoryUpdateException();
        }

        return $userModel;
    }

    private function getFillable(): array
    {
        return $this->model->getFillable();
    }
}
