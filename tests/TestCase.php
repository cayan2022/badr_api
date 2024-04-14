<?php

namespace Tests;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    public function setUp(): void
    {
        // first include all the normal setUp operations
        parent::setUp();
        Config::set('filesystems.disks.public', [
            'driver' => 'local',
            'root' => Config::get('media-library.test_folder'),
        ]);
        $this->seed(DatabaseSeeder::class);
    }

}
