<?php

use Illuminate\Database\Seeder;
use \App\Models\HR\ShiftDetail;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['Umum', 'Pagi', 'Sore', 'Malam'];
        foreach ($names as $name) {
            $shift = \App\Models\HR\Shift::create([
                'company_id' => 1,
                'name' => $name
            ]);

            $workDays = \App\Models\HR\WorkDay::all();
            foreach ($workDays as $workDay) {
                if ($workDay->is_weekday == 1) {
                    if ($name == "Umum") {
                        ShiftDetail::create([
                            'shift_id' => $shift->id,
                            'work_day_id' => $workDay->id,
                            'work_time_id' => 2,
                        ]);
                    } elseif ($name == 'Pagi') {
                        ShiftDetail::create([
                            'shift_id' => $shift->id,
                            'work_day_id' => $workDay->id,
                            'work_time_id' => 3,
                        ]);
                    } elseif ($name == 'Sore') {
                        ShiftDetail::create([
                            'shift_id' => $shift->id,
                            'work_day_id' => $workDay->id,
                            'work_time_id' => 4,
                        ]);
                    } elseif ($name == 'Malam') {
                        ShiftDetail::create([
                            'shift_id' => $shift->id,
                            'work_day_id' => $workDay->id,
                            'work_time_id' => 5,
                        ]);
                    }
                } else {
                    ShiftDetail::create([
                        'shift_id' => $shift->id,
                        'work_day_id' => $workDay->id,
                        'work_time_id' => null,
                    ]);
                }
            }
        }
    }
}
