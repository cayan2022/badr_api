<?php
namespace App\Helpers\Traits;

use Faker\Factory;
use Faker\Generator;

trait CustomFactoryLocal{
    public Generator $localFaker;

    public function localFaker($local='ar_SA'): Generator
    {
        if (in_array(
            $local,
            config('app.available_faker_locales'),
            true
        )){
            $this->localFaker = Factory::create($local);
        }else{
            $this->localFaker = Factory::create(config('app.faker_locale'));
        }
        return $this->localFaker;
    }
}
