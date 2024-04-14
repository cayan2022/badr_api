<?php

namespace Database\Factories;

use App\Helpers\Traits\CustomFactoryLocal;
use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    use CustomFactoryLocal;
    protected $model=Blog::class;
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
                'short_description' =>$this->faker->paragraph(),
                'long_description' =>$this->faker->text,
            ],
            'ar' => [
                'title' =>$this->localFaker()->name,
                'short_description' =>$this->localFaker()->paragraph(),
                'long_description' =>$this->localFaker()->text,
            ],

            'reference_link'=>$this->faker->url,
            'date'=>$this->faker->date(),
            'is_block'=>$this->faker->boolean,
        ];
    }
}
