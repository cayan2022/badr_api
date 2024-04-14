<?php

namespace Database\Factories;

use App\Models\Source;
use App\Helpers\Traits\CustomFactoryLocal;
use Illuminate\Database\Eloquent\Factories\Factory;

class SourceFactory extends Factory
{
    use CustomFactoryLocal;
    protected $model=Source::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'en' => [
                'name' =>$this->faker->name(),
                'short_description'=>$this->faker->sentence(),
            ],
            'ar' => [
                'name' =>$this->localFaker()->name(),
                'short_description'=>$this->localFaker()->sentence(),
            ],
            'identifier'=>$this->faker->unique()->word(),
            'is_block'=>$this->faker->boolean,
        ];

    }
}
