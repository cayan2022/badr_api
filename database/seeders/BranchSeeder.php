<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
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
        Branch::factory()->count($this->count)->create();
    }
}
