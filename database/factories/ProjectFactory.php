<?php

namespace Database\Factories;

use App\Models\Project;
use App\Helpers\Traits\CustomFactoryLocal;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    use CustomFactoryLocal;
    protected $model=Project::class;
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
                'classification' =>$this->faker->text(),
                'short_description' =>$this->faker->text(),
                'full_description' =>$this->faker->text(),
            ],
            'ar' => [
                'name' =>$this->localFaker()->name(),
                'classification' =>$this->localFaker()->sentence(),
                'short_description' =>$this->localFaker()->sentence(),
                'full_description' =>$this->localFaker()->sentence(),
            ],
            'is_block'=>$this->faker->boolean,
        ];
    }
}
