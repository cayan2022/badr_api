<?php

namespace Database\Factories;

use App\Helpers\Traits\CustomFactoryLocal;
use App\Models\Category;
use App\Models\Tiding;
use Illuminate\Database\Eloquent\Factories\Factory;

class TidingFactory extends Factory
{
    protected $model=Tiding::class;
    use CustomFactoryLocal;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'en' => [
                'name' =>$this->faker->name,
                'short_description' =>$this->faker->text,
                'description' =>$this->faker->paragraph(20),
            ],
            'ar' => [
                'name' =>$this->localFaker()->name,
                'short_description' =>$this->localFaker()->text,
                'description' =>$this->faker->paragraph(20),
            ],
            'link' =>'https://www.wikipedia.org/',
            'date'=>$this->faker->date(),
            'is_block'=>$this->faker->boolean,
        ];
    }
}
