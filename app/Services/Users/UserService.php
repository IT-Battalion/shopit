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
use Illuminate\Support\Facades\Auth;

class UserService implements UserServiceInterface
{
    /**
     * @throws ActionNotAllowedForAdministratorExeption
     * @throws UserBannedException
     */
    function ban(User $user): bool
    {
        if ($this->canBePerformedOnUser($user)) {
            if ($user->enabled) {
                event(new UserBanningEvent($user));
                $user->banWith(Auth::user());
                $user->disabled_at = now();
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
            if (!$user->enabled) {
                event(new UserUnbanningEvent($user));
                $user->enabled = true;
                $user->disabled_at = null;
                $user->disabled_by_id = null;
                $user->save();
                event(new UserUnbannedEvent($user));
                return true;
            } else {
                throw new UserNotBannedException();
            }
        }
        return false;
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
