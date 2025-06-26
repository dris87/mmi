<?php

namespace App\Lib\PasswordReset;

class PasswordResetService
{
    private $passwordResetRepository;

    public function __construct(
        PasswordResetRepository $passwordResetRepository
    ) {
        $this->passwordResetRepository = $passwordResetRepository;
    }

    public function passwordRequest($user)
    {
        $email = $user->getEmail();
        $token = str_random(60);

        $paswordResetModel = $this->passwordResetRepository->create($email, $token);

        return $paswordResetModel->getToken();
    }

    public function getRepository(): PasswordResetRepository
    {
        return $this->passwordResetRepository;
    }
}
