<?php

namespace App\Lib\PasswordReset;

use App\Models\PasswordReset;

class PasswordResetRepository
{
    public function getByToken(string $token)
    {
        return PasswordReset::where('token', $token)->orderBy('created_at', 'desc')->first();
    }

    public function create(string $email, string $token)
    {
        return PasswordReset::create([
            'email' => $email,
            'token' => $token
        ]);
    }
}
