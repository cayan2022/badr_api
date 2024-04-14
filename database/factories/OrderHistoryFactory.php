<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\SubStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderHistoryFactory extends Factory
{
    protected $model=OrderHistory::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id'=>Order::factory()->create(),
            'sub_status_id'=>SubStatus::inRandomOrder()->take(1)->first()->id,
            'user_id' => User::first()->id,
            'description'=>$this->faker->text,
            'duration'=>$this->faker->dateTime(),
        ];
    }
}
