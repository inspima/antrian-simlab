<?php

use App\Models\Account\Personal;
use App\Models\Account\Role;
use App\Models\Master\Organization;
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
            'password' => bcrypt('itdunair'),
            'role' => Role::find(1)->name,
            // 'avatar' => 'avatar.png'
        ]);

        $organization = Organization::create([
            'code' => 'CO/000001',
            'type' => 'Perusahaan',
            'name' => 'Inspima Creative Technology',
            'address' => 'Jl.Margorejo 7a, Surabaya, Jawa Timur Indonesia',
        ]);

        Personal::create([
            'user_id' => $user->id,
            'organization_id' => $organization->id,
            'name' => $user->name,
            'address' => $organization->address,
        ]);

        // Create default user
        $user = User::create([
            'name' => 'RS Berusaha Sehat',
            'email' => 'rs1@email.com',
            'password' => bcrypt('itdunair'),
            'role' => Role::find(2)->name,
            // 'avatar' => 'avatar.png'
        ]);

        $organization = Organization::create([
            'code' => 'RS/000001',
            'type' => 'Rumah Sakit',
            'name' => 'RS Berusaha Sehat',
            'address' => 'Jl.Berusaha 10, Surabaya, Jawa Timur Indonesia',
        ]);

        Personal::create([
            'user_id' => $user->id,
            'organization_id' => $organization->id,
            'name' => $user->name,
            'address' => $organization->address,
        ]);

        // Create default user
        $user = User::create([
            'name' => 'RS Berjuang Sehat',
            'email' => 'rs2@email.com',
            'password' => bcrypt('itdunair'),
            'role' => Role::find(2)->name,
            // 'avatar' => 'avatar.png'
        ]);

        $organization = Organization::create([
            'code' => 'RS/000001',
            'type' => 'Rumah Sakit',
            'name' => 'RS Berjuang Sehat',
            'address' => 'Jl.Berjuang 10, Surabaya, Jawa Timur Indonesia',
        ]);

        Personal::create([
            'user_id' => $user->id,
            'organization_id' => $organization->id,
            'name' => $user->name,
            'address' => $organization->address,
        ]);
    }
}
