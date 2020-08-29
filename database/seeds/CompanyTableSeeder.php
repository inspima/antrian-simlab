<?php

use App\Models\Organization\Company;
use Illuminate\Database\Seeder;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'code' => 'CO/0001',
            'name' => 'Asaba Computer Center',
            'short_name' => 'ASABA',
            'country' => 'Indonesia',
            'province' => 'Daerah Khusus Ibukota Jakarta',
            'city' => 'Kota Jakarta Selatan',
            'district' => 'Kuningan',
            'sub_district' => 'Karet',
            'address' => 'Ebenezer Building, Jl. Setia Budi Selatan No.1, RT.5/RW.5',
            'map_address' => 'Ebenezer Building, Jl. Setia Budi Selatan No.1, RT.5/RW.5',
            'latitude' => '-6.213076',
            'longitude' => '106.826755',
            'favicon' => 'default.png',
            'logo' => 'logo-asaba.png',
            'phone' => '021-57994700',
        ]);
    }
}
