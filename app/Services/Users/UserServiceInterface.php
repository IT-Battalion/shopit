<?php

namespace App\Services\Users;

use App\Models\User;

interface UserServiceInterface
{
    /**
     * Bans a specific User
     * @param User $user the specific User Model
     * @return bool true if the User has been banned successfully else false
     */
    function ban(User $user): bool;

    /**
     * Unbans the specific User
     * @param User $user the specific User Model
     * @return bool true if the User has been unbanned else false
     */
    function unban(User $user): bool;

    /**
     * Returns if the User is banned or not
     * @param User $user the specific User Model
     * @return bool true if the User is banned else false
     */
    function isBanned(User $user): bool;

    /**
     * Determines if an Action can be performed on a given User.
     * @param User $user The user which should be checked for.
     * @return bool true if the action can be performed. else false.
     */
    function canBePerformedOnUser(User $user): bool;
}
