<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\CouponCode;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

class OrderFactory extends Factory
{
    /**
     * The number of coupon codes
     */
    public const COUPON_CODE_CHANCE = 25;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $admin_received = Admin::all()->random()->id;
        $admin_handed = Admin::all()->random()->id;
        $admin_ordered = Admin::all()->random()->id;
        $admin_transaction = Admin::all()->random()->id;

        $hasCoupon = $this->faker->boolean(self::COUPON_CODE_CHANCE);
        $coupon = $hasCoupon ? function() {
            $dbCoupon = CouponCode::whereEnabled(true)->get()->random();
            return $dbCoupon->id;
        } : null;

        $hasPayed = $this->faker->boolean(90);
        $hasOrdered = $hasPayed && $this->faker->boolean(80);
        $hasReceived = $hasOrdered && $this->faker->boolean(70);
        $hasHanded = $hasReceived && $this->faker->boolean(60);

        return [
            'customer_id' => User::all()->random()->id,
            'coupon_code_id' => $coupon,
            'paid_at' => $hasPayed ? Date::now() : null,
            'transaction_confirmed_by_id' => $hasPayed ? $admin_transaction : null,
            'products_ordered_at' => $hasOrdered ? Date::now()->addDays(2) : null,
            'products_ordered_by_id' => $hasOrdered ? $admin_ordered : null,
            'products_received_at' => $hasReceived ? Date::now()->addDays(20) : null,
            'products_received_by_id' => $hasReceived ? $admin_received : null,
            'handed_over_at' => $hasHanded ? Date::now()->addDays(22) : null,
            'handed_over_by_id' => $hasHanded ? $admin_handed : null,
        ];
    }
}
