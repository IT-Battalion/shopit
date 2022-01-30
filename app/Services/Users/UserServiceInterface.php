<?php

namespace App\Services\Users;

use App\Exceptions\ActionNotAllowedForAdministratorException;
use App\Exceptions\UserBannedException;
use App\Exceptions\UserNotBannedException;
use App\Models\User;

interface UserServiceInterface
{
    /**
     * Bans a specific User
     * @param User $user the specific User Model
     * @throws ActionNotAllowedForAdministratorException
     * @throws UserBannedException
     */
    function ban(User $user, string $reason);

    /**
     * Unbans the specific User
     * @param User $user the specific User Model
     * @throws UserNotBannedException
     * @throws ActionNotAllowedForAdministratorException
     */
    function unban(User $user);
}
