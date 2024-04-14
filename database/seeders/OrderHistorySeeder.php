<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\SubStatus;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Seeder;

class OrderHistorySeeder extends Seeder
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
        OrderHistory::factory([
                                  'order_id' => Order::inRandomOrder()->first()->id,
                                  'sub_status_id' => SubStatus::inRandomOrder()->first()->id,
                              ])->count($this->count)->create();
    }
}
