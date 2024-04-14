<?php

namespace Database\Factories;

use App\Helpers\Traits\CustomFactoryLocal;
use App\Models\About;
use Illuminate\Database\Eloquent\Factories\Factory;

class AboutFactory extends Factory
{
    use CustomFactoryLocal;
    protected $model=About::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'en' => [
                'title' =>$this->faker->title,
                'description' =>$this->faker->paragraph(),
            ],
            'ar' => [
                'title' =>$this->localFaker()->name,
                'description' =>$this->faker->paragraph(),
            ],
            'is_block'=>$this->faker->boolean()
        ];
    }
}
