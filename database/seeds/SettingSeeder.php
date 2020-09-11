<?php

use Illuminate\Database\Seeder;
use  \App\Models\General\Setting;
use App\Models\Master\Holiday;
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

        QuotaQueue::create([
            'type' => 'organization',
            'quota' => '20',
        ]);

        QuotaOrganization::create([
            'organization_id' => 1,
            'quota' => '20',
        ]);

        QuotaOrganization::create([
            'organization_id' => 2,
            'quota' => '30',
        ]);

        Holiday::create([
            'date' => '2020-09-16',
            'description' => 'Hari Raya Galungan 2'
        ]);
        Holiday::create([
            'date' => '2020-09-26',
            'description' => 'Hari Raya Kuningan 2'
        ]);
        
        Holiday::create([
            'date' => '2020-10-28',
            'description' => '​Maulid Nabi Muhammad SAW​'
        ]);
        
        Holiday::create([
            'date' => '2020-10-29',
            'description' => '​Maulid Nabi Muhammad SAW​'
        ]);
        
        Holiday::create([
            'date' => '2020-10-30',
            'description' => '​Maulid Nabi Muhammad SAW​'
        ]);
    }
}
