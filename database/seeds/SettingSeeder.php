<?php

use Illuminate\Database\Seeder;
use  \App\Models\General\Setting;
use App\Models\Process\QuotaOrganization;
use App\Models\Process\QuotaQueue;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        QuotaQueue::create([
            'type' => 'day',
            'quota' => '200',
        ]);

        QuotaOrganization::create([
            'organization_id' => 2,
            'quota' => '20',
        ]);

        QuotaOrganization::create([
            'organization_id' => 2,
            'quota' => '30',
        ]);
    }
}
