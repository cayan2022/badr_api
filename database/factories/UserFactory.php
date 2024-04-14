<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'type'=>$this->faker->randomElement(User::TYPES),
            'country_id'=>Country::inRandomOrder()->take(1)->first()->id,
            'phone'=>$this->faker->phoneNumber,
            'email' => $this->faker->unique()->freeEmail,
            'email_verified_at' => now(),
            'password' => 'password', // it will be set to hash password from user model mutators
            'remember_token' => Str::random(10),
            'is_block'=>$this->faker->boolean
        ];
    }
}
