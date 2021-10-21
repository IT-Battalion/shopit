<?php

namespace App\Services\Users;

use App\Models\ShoppingCart;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserServiceInterface {
    /**
     * Bans a specific User
     * @param User $user the specific User Model
     * @return bool true if the User has been banned successfully else false
     */
    function ban(User $user) : bool;

    /**
     * Unbans the specific User
     * @param User $user the specific User Model
     * @return bool true if the User has been unbanned else false
     */
    function unban(User $user) : bool;

    /**
     * Returns if the User is banned or not
     * @param User $user the specific User Model
     * @return bool true if the User is banned else false
     */
    function isBanned(User $user) : bool;

    /**
     * Returns the Users Orders
     * @param User $user the specific User Model
     * @return Collection the Collection containing the Users Orders
     */
    function getOrders(User $user) : Collection;

    /**
     * Returns the Shopping Cart of a specific User
     * @param User $user the specific User Model
     * @return ShoppingCart the Shopping Cart Model
     */
    function getShoppingCart(User $user) : ShoppingCart;
}
