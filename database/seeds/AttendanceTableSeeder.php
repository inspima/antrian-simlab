<?php

use App\Models\Attendance\Event;
use App\Models\Attendance\Location;
use App\Models\Organization\WorkPlace;
use Illuminate\Database\Seeder;

class AttendanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WorkPlace::create([
            'company_id' => 1,
            'name' => 'Kantor Pusat Asaba',
            'country' => 'Indonesia',
            'province' => 'Daerah Khusus Ibukota Jakarta',
            'city' => 'Kota Jakarta Selatan',
            'district' => 'Kuningan',
            'address' => 'Ebenezer Building, Jl. Setia Budi Selatan No.1, RT.5/RW.5',
            'map_address' => 'Ebenezer Building, Jl. Setia Budi Selatan No.1, RT.5/RW.5',
            'latitude' => '-6.213076',
            'longitude' => '106.826755',
            'phone' => '021-57994700',
        ]);

        WorkPlace::create([
            'company_id' => 1,
            'name' => 'Kantor Cabang Asaba',
            'country' => 'Indonesia',
            'province' => 'Jawa Timur',
            'city' => 'Kota Malang',
            'district' => 'Blimbing',
            'address' => 'Jl. Candi Kalasan 3, No 11',
            'map_address' => 'Jl. Candi Kalasan 3, No 11',
            'latitude' => '-7.943094',
            'longitude' => '112.638987',
            'phone' => '021-57994700',
        ]);

        $location = Location::create([
            'name' => 'Kantor Pusat Asaba',
            'country' => 'Indonesia',
            'province' => 'Daerah Khusus Ibukota Jakarta',
            'city' => 'Kota Jakarta Selatan',
            'district' => 'Kuningan',
            'address' => 'Ebenezer Building, Jl. Setia Budi Selatan No.1, RT.5/RW.5',
            'map_address' => 'Ebenezer Building, Jl. Setia Budi Selatan No.1, RT.5/RW.5',
            'latitude' => '-6.213076',
            'longitude' => '106.826755',
            'phone' => '021-57994700',
        ]);

        Event::create([
            'location_id' => $location->id,
            'name' => 'Rapat External',
        ]);
    }
}
