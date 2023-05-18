<?php

namespace App\Service;

interface UserIdentityProvider
{
    public function getUserById(int $userId): ?UserIdentity;
}
