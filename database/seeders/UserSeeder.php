<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create super admin role and user - check auth service provider
        $superAdminRole = Role::query()->firstOrCreate(['name' => 'super-admin', 'guard_name' => 'api']);
        $superAdminRole->syncPermissions(Permission::all()->pluck('id')->toArray());
        $superAdminUser = User::factory()->create(['email' => 'super-admin@gmail.com','type'=>User::MODERATOR,'is_block'=>false]);
        $superAdminUser->assignRole($superAdminRole);
    }
}
