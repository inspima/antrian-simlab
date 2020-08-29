<?php

use Illuminate\Database\Seeder;
use App\Models\HR\WorkTime;

class WorkTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WorkTime::create([
            // 'id' => 1,
            'start_time' => '08:00',
            'end_time' => '17:00',
        ]);

        WorkTime::create([
            // 'id' => 2,
            'start_time' => '09:00',
            'end_time' => '18:00',
        ]);

        WorkTime::create([
            // 'id' => 3,
            'start_time' => '07:00',
            'end_time' => '15:00',
        ]);

        WorkTime::create([
            // 'id' => 4,
            'start_time' => '15.00',
            'end_time' => '23:00',
        ]);

        WorkTime::create([
            // 'id' => 5,
            'start_time' => '23:00',
            'end_time' => '07:00',
        ]);
    }
}
