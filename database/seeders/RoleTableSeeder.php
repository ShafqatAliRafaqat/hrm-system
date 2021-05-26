<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $aRoles = array(
            array('name' => "Super Admin"),
            array('name' => "Admin"),
            array('name' => "Sub Admin"),
        );
        foreach ($aRoles as $role) {
            Role::create($role);
        }
    }
}
