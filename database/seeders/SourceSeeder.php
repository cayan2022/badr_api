<?php

namespace Database\Seeders;

use App\Models\Source;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Seeder;

class SourceSeeder extends Seeder
{
    /**
     * @var Repository|Application|mixed
     */
    private $count;

    public function __construct()
    {
        $this->count=config('database.seeder_count');
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Source::factory([
                            'en' => [
                                'name' =>'website',
                                'short_description'=>'coming from website',
                            ],
                            'ar' => [
                                'name' =>'الموقع',
                                'short_description'=>'من خلال الموقع',
                            ],
                            'identifier'=>'website',
                            'is_block'=>false,
                        ])->create();
    }
}
