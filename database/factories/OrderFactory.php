<?php

namespace Database\Factories;

use App\Portal\Models\City;
use App\Portal\Models\Order;
use App\Portal\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
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
        $total_cost = $this->faker->randomNumber(3);
        $platform_fee = ($total_cost/100)*30;
        $status = $this->faker->randomElement(['new', 'is_pending', 'in_progress', 'done_by_master', 'checking_by_manager', 'completed', 'cancelled']);
        $cancel_reason = $status == 'cancelled' ? $this->faker->realText() : null;

        return [
            'phone_number' => $this->faker->phoneNumber,
            'status' => $status,
            'master_id' => User::role('master')->inRandomOrder()->first()->id,
            'city_id' => City::inRandomOrder()->first()->id,
            'address' => $this->faker->address,
            'total_cost' => $total_cost,
            'platform_fee' => $platform_fee,
            'comment' => $this->faker->realText(),
            'cancel_reason' => $cancel_reason,
        ];
    }
}
