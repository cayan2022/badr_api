<?php

namespace Database\Factories;

use App\Helpers\Traits\CustomFactoryLocal;
use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

class PartnerFactory extends Factory
{
    use CustomFactoryLocal;
    protected $model=Partner::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'en' => [
                'name' =>$this->faker->company,
            ],
            'ar' => [
                'name' =>$this->localFaker()->company,
            ],

            'link'=>$this->faker->url,
            'is_block'=>$this->faker->boolean,
        ];
    }
}
