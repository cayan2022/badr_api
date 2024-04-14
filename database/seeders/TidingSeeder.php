<?php

namespace Database\Seeders;

use App\Models\Tiding;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class TidingSeeder extends Seeder
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
       Tiding::factory()->count($this->count)->create();
    }
}
