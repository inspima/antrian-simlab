<?php

use App\Models\Account\Personal;
use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create default user
        $user = User::create([
            'name' => 'Administrator',
            'email' => 'admin@email.com',
            'password' => bcrypt('admin'),
            // 'avatar' => 'avatar.png'
        ]);

        Personal::create([
            'user_id' => $user->id,
            'company_id' => 1,
            'work_group_id' => 6,
            'work_place_id' => 1,
            'shift_id' => 1,
            'work_id_number' => str_pad(6, 4, '0', STR_PAD_LEFT) . '/' . str_pad($user->id, 6, '0', STR_PAD_LEFT),
            'id_number' => '3579712664188',
            'name' => $user->name,
            'address' => 'Jl.Abcd No 123'
        ]);

        // Create default user
        $user = User::create([
            'name' => 'Sales Staff',
            'email' => 'sales-staff@email.com',
            'password' => bcrypt('admin'),
            // 'avatar' => 'avatar.png'
        ]);

        Personal::create([
            'user_id' => $user->id,
            'company_id' => 1,
            'work_group_id' => 1,
            'work_place_id' => 1,
            'shift_id' => 1,
            'work_id_number' => str_pad(1, 4, '0', STR_PAD_LEFT) . '/' . str_pad($user->id, 6, '0', STR_PAD_LEFT),
            'id_number' => '3579712664185',
            'address' => 'Jl.Defg No 456',
            'name' => $user->name,
        ]);
    }
}
