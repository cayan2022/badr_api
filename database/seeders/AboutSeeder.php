<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
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
        About::factory()->count($this->count)->create();
    }
}
