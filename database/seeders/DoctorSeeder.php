<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
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
        Doctor::factory()->count($this->count)->create();
    }
}
