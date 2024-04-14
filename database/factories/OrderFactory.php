<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Order;
use App\Models\Source;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model=Order::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(['type'=>User::PATIENT])->create(),
            'category_id' => Category::factory()->create(),
            'source_id' => Source::factory()->create(),
            'status_id' => Status::inRandomOrder()->take(1)->first()->id,
            'branch_id' => Branch::inRandomOrder()->take(1)->first()->id,
        ];
    }
}
