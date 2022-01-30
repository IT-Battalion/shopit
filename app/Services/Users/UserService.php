<?php

namespace App\Services\Users;

use App\Events\UserBannedEvent;
use App\Events\UserUnbannedEvent;
use App\Exceptions\ActionNotAllowedForAdministratorException;
use App\Exceptions\UserBannedException;
use App\Exceptions\UserNotBannedException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService implements UserServiceInterface
{
    /**
     * @inheritdoc
     */
    function ban(User $user, string $reason)
    {
        if ($user->bannable) {
            if ($user->enabled) {
                $user->banWith(Auth::user()->asAdmin());
                $user->reason_for_disabling = $reason;
                $user->save();
                event(new UserBannedEvent($user));
            } else {
                throw new UserBannedException();
            }
        } else {
            throw new ActionNotAllowedForAdministratorException();
        }
    }

    /**
     * @inheritdoc
     */
    function unban(User $user)
    {
        if ($user->bannable) {
            if (!$user->enabled) {
                $user->update([
                    'enabled' => true,
                    'disabled_at' => null,
                    'disabled_by_id' => null,
                    'reason_for_disabling' => null,
                ]);
                event(new UserUnbannedEvent($user));
            } else {
                throw new UserNotBannedException();
            }
        } else {
            throw new ActionNotAllowedForAdministratorException();
        }
    }
}
