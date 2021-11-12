<?php

namespace App\Services\Users;

use App\Events\UserBannedEvent;
use App\Events\UserBanningEvent;
use App\Events\UserUnbannedEvent;
use App\Events\UserUnbanningEvent;
use App\Exceptions\ActionNotAllowedForAdministratorExeption;
use App\Exceptions\UserBannedException;
use App\Exceptions\UserNotBannedException;
use App\Models\User;

class UserService implements UserServiceInterface
{
    /**
     * @throws ActionNotAllowedForAdministratorExeption
     * @throws UserBannedException
     */
    function ban(User $user): bool
    {
        if ($this->canBePerformedOnUser($user)) {
            if (!$this->isBanned($user)) {
                event(new UserBanningEvent($user));
                $user->enabled = false;
                $user->save();
                event(new UserBannedEvent($user));
                return true;
            } else {
                throw new UserBannedException();
            }
        }
        return false;
    }

    /**
     * @throws UserNotBannedException
     * @throws ActionNotAllowedForAdministratorExeption
     */
    function unban(User $user): bool
    {
        if ($this->canBePerformedOnUser($user)) {
            if ($this->isBanned($user)) {
                event(new UserUnbanningEvent($user));
                $user->enabled = true;
                $user->save();
                event(new UserUnbannedEvent($user));
                return true;
            } else {
                throw new UserNotBannedException();
            }
        }
        return false;
    }

    function isBanned(User $user): bool
    {
        return !$user->enabled;
    }

    /**
     * @throws ActionNotAllowedForAdministratorExeption
     */
    function canBePerformedOnUser(User $user): bool
    {
        if (!$user->isAdmin) {
            return true;
        } else {
            throw new ActionNotAllowedForAdministratorExeption();
        }
    }
}
