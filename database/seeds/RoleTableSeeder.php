<?php

use App\Models\Account\Role;
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
        Role::create([
            'name' => 'Administration',
        ]);
        Role::create([
            'name' => 'Organization',
        ]);
    }
}
