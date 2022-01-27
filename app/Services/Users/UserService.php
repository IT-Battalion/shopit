<?php

namespace App\Services\Users;

use App\Events\UserBannedEvent;
use App\Events\UserBanningEvent;
use App\Events\UserUnbannedEvent;
use App\Events\UserUnbanningEvent;
use App\Exceptions\ActionNotAllowedForAdministratorException;
use App\Exceptions\UserBannedException;
use App\Exceptions\UserNotBannedException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService implements UserServiceInterface
{
    /**
     * @throws ActionNotAllowedForAdministratorException
     * @throws UserBannedException
     */
    function ban(User $user, string $reason): bool
    {
        if ($this->canBePerformedOnUser($user)) {
            if ($user->enabled) {
                event(new UserBanningEvent($user));
                $user->banWith(Auth::user());
                $user->disabled_at = now();
                $user->enabled = false;
                $user->reason_for_disabling = $reason;
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
     * @throws ActionNotAllowedForAdministratorException
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
     * @throws ActionNotAllowedForAdministratorException
     */
    function canBePerformedOnUser(User $user): bool
    {
        if (!$user->is_admin) {
            return true;
        } else {
            throw new ActionNotAllowedForAdministratorException();
        }
    }
}
