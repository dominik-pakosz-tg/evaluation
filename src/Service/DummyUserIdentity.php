<?php

namespace App\Service;

class DummyUserIdentity implements UserIdentity
{
    public function __construct(
        private readonly string $userId,
        private readonly ?string $email,
        private readonly string $phone,
        private readonly string $appToken
    ) {
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getAppToken(): string
    {
        return $this->appToken;
    }
}
