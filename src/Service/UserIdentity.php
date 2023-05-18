<?php

namespace App\Service;

interface UserIdentity
{
    public function getUserId(): string;

    public function getEmail(): ?string;

    public function getPhone(): ?string;

    public function getAppToken(): ?string;
}
