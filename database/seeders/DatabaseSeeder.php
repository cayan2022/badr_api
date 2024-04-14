<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Contracts\Container\BindingResolutionException;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function run()
    {
        /*
         * note:first before create orders you must create one record at these tables in same order:
        categories,source,branch
        also must run seeder for
        statues and substatuses
        */
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
        //the order is very important
        $this->call(
            [
                CountrySeeder::class,
                PermissionSeeder::class,
                RoleSeeder::class,
                UserSeeder::class,
                SettingSeeder::class,
                SourceSeeder::class,
                StatusSeeder::class,
                SubStatusSeeder::class,
            ]
        );
    }
}
