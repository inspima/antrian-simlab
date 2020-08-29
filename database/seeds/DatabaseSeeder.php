<?php

use App\Models\Attendance\Attendance;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CompanyTableSeeder::class);
        $this->call(AttendanceTableSeeder::class);
        $this->call(HRTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(WorkDaySeeder::class);
        $this->call(WorkTimeSeeder::class);
        $this->call(ShiftSeeder::class);
    }
}
