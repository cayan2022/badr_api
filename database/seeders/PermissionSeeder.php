<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create permissions
        $this->createPermissions();
    }

    protected function createPermissions()
    {
        permission::create(['name' => 'show roles', 'type' => 'roles', 'guard_name' => 'api']);
        permission::create(['name' => 'create roles', 'type' => 'roles', 'guard_name' => 'api']);
        permission::create(['name' => 'update roles', 'type' => 'roles', 'guard_name' => 'api']);
        permission::create(['name' => 'assign roles', 'type' => 'roles', 'guard_name' => 'api']);

        permission::create(['name' => 'update settings', 'type' => 'settings', 'guard_name' => 'api']);

        permission::create(['name' => 'create orders', 'type' => 'orders', 'guard_name' => 'api']);
        permission::create(['name' => 'show orders', 'type' => 'orders', 'guard_name' => 'api']);
        permission::create(['name' => 'follow orders', 'type' => 'orders', 'guard_name' => 'api']);

        permission::create(['name' => 'show sources reports', 'type' => 'reports', 'guard_name' => 'api']);
        permission::create(['name' => 'show moderators reports', 'type' => 'reports', 'guard_name' => 'api']);
        permission::create(['name' => 'show statuses reports', 'type' => 'reports', 'guard_name' => 'api']);

        $items = ['profiles', 'doctors', 'testimonials', 'offers', 'services', 'tidings', 'categories', 'blogs', 'abouts', 'partners', 'projects', 'sources', 'branches', 'customers', 'portfolio-categories', 'portfolios','contact-us'];
        foreach ($items as $item) {
            permission::create(['name' => "show $item", 'type' => $item, 'guard_name' => 'api']);
            permission::create(['name' => "create $item", 'type' => $item, 'guard_name' => 'api']);
            permission::create(['name' => "update $item", 'type' => $item, 'guard_name' => 'api']);
            permission::create(['name' => "delete $item", 'type' => $item, 'guard_name' => 'api']);
            permission::create(['name' => "block $item", 'type' => $item, 'guard_name' => 'api']);
            permission::create(['name' => "active $item", 'type' => $item, 'guard_name' => 'api']);
        }

    }
}
