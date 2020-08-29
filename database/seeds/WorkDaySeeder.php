<?php

use Illuminate\Database\Seeder;
use App\Models\HR\WorkDay;

class WorkDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WorkDay::create([
            // 'id' => 1,
            'day' => 'Senin',
            'is_weekday' => 1,
            'is_weekend' => 0
        ]);
        WorkDay::create([
            // 'id' => 2,
            'day' => 'Selasa',
            'is_weekday' => 1,
            'is_weekend' => 0
        ]);
        WorkDay::create([
            // 'id' => 3,
            'day' => 'Rabu',
            'is_weekday' => 1,
            'is_weekend' => 0
        ]);
        WorkDay::create([
            // 'id' => 4,
            'day' => 'Kamis',
            'is_weekday' => 1,
            'is_weekend' => 0
        ]);
        WorkDay::create([
            // 'id' => 5,
            'day' => 'Jumat',
            'is_weekday' => 1,
            'is_weekend' => 0
        ]);
        WorkDay::create([
            // 'id' => 6,
            'day' => 'Sabtu',
            'is_weekday' => 0,
            'is_weekend' => 1
        ]);
        WorkDay::create([
            // 'id' => 7,
            'day' => 'Minggu',
            'is_weekday' => 0,
            'is_weekend' => 1
        ]);
    }
}
