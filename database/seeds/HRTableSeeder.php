<?php

use App\Models\HR\Shift;
use App\Models\HR\WorkGroup;
use App\Models\HR\WorkPosition;
use App\Models\HR\WorkTime;
use Illuminate\Database\Seeder;

class HRTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WorkPosition::create([
            'name' => 'Director',
            'level' => 1
        ]);
        WorkPosition::create([
            'name' => 'Manager',
            'level' => 2
        ]);
        WorkPosition::create([
            'name' => 'Supervisor',
            'level' => 3
        ]);
        WorkPosition::create([
            'name' => 'Staff',
            'level' => 4
        ]);

        WorkGroup::create([
            'company_id'=>1,
            'shift_id'=>1,
            'name'=>"Sales",
        ]);
        WorkGroup::create([
            'company_id'=>1,
            'shift_id'=>1,
            'name'=>"Accounting",
        ]);

        WorkGroup::create([
            'company_id'=>1,
            'shift_id'=>1,
            'name'=>"Consultant",
        ]);
        WorkGroup::create([
            'company_id'=>1,
            'shift_id'=>1,
            'name'=>"IT Engineer",
        ]);
        WorkGroup::create([
            'company_id'=>1,
            'shift_id'=>1,
            'name'=>"IT Support Specialist",
        ]);
        WorkGroup::create([
            'company_id'=>1,
            'shift_id'=>1,
            'name'=>"IT System Administration",
        ]);
        WorkGroup::create([
            'company_id'=>1,
            'shift_id'=>1,
            'name'=>"Administration",
        ]);
        WorkGroup::create([
            'company_id'=>1,
            'shift_id'=>1,
            'name'=>"HRD",
        ]);
    }
}
