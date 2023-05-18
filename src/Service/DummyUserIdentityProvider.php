<?php

namespace App\Service;

class DummyUserIdentityProvider implements UserIdentityProvider
{
    public function getUserById(int $userId): ?UserIdentity
    {
        // This is just for sake of testing, always provide a user.
        return new DummyUserIdentity($userId, 'johndoe@example.com', '+35805465465456', 'wkienl55wedflkjsd5');
    }
}
