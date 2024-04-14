<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\Source;
use App\Models\Status;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * @var Repository|Application|mixed
     */
    private $count;

    public function __construct()
    {
        $this->count = config('database.seeder_count');
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::factory()->count($this->count)->create();
    }
}
