<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::updateOrCreate(['slug' => 'root'],     ['name' => 'Root',     'description' => 'System administration only']);
        Role::updateOrCreate(['slug' => 'sysadmin'], ['name' => 'SysAdmin', 'description' => 'System Administrator']);
        Role::updateOrCreate(['slug' => 'reseller'], ['name' => 'Reseller', 'description' => 'Account Reseller']);
    }
}
