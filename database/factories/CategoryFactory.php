<?php

namespace Database\Factories;

use App\Helpers\Traits\CustomFactoryLocal;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    use CustomFactoryLocal;
    protected $model=Category::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'en' => ['name' =>$this->faker->name,'description' =>$this->faker->text],
            'ar' => ['name' => $this->localFaker()->name,'description' => $this->localFaker()->text],

            'is_block'=>$this->faker->boolean,

        ];
    }
}
