<?php

namespace App\Services\Users;

use App\Exceptions\ActionNotAllowedForAdministratorExeption;
use App\Exceptions\UserBannedException;
use App\Exceptions\UserNotBannedException;
use App\Models\Order;
use App\Models\ShoppingCart;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserService implements UserServiceInterface
{
    /**
     * @inheritDoc
     * @throws ActionNotAllowedForAdministratorExeption
     * @throws UserBannedException
     */
    function ban(User $user): bool
    {
        if ($this->canBePerformedOnUser($user)) {
            if (!$this->isBanned($user)) {
                $user->disable();
                $user->save();
                return true;
            } else {
                throw new UserBannedException();
            }
        }
        return false;
    }

    /**
     * @inheritDoc
     * @throws UserNotBannedException
     * @throws ActionNotAllowedForAdministratorExeption
     */
    function unban(User $user): bool
    {
        if ($this->canBePerformedOnUser($user)) {
            if ($this->isBanned($user)) {
                $user->enable();
                $user->save();
                return true;
            } else {
                throw new UserNotBannedException();
            }
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    function isBanned(User $user): bool
    {
        return !$user->enabled;
    }

    /**
     * @inheritDoc
     */
    function getOrders(User $user): Collection
    {
        return Order::whereCustomer($user->id)->get();
    }

    /**
     * @inheritDoc
     */
    function getShoppingCart(User $user): ShoppingCart
    {
        return ShoppingCart::whereUserId($user->id);
    }

    /**
     * @throws ActionNotAllowedForAdministratorExeption
     */
    private function canBePerformedOnUser(User $user): bool
    {
        if (!$user->isAdmin) {
            return true;
        } else {
            throw new ActionNotAllowedForAdministratorExeption();
        }
    }
}
