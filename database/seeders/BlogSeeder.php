<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
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
        Blog::factory()->count($this->count)->create();
    }
}
