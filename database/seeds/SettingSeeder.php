<?php

use Illuminate\Database\Seeder;
use  \App\Models\General\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            "code" => "qr_time",
            "name" => "qr time validation",
            "description" => "number value on second",
            "value" => "10",
        ]);

        Setting::create([
            "code" => "voice",
            "name" => "voice",
            "description" => "'file_voice','local_voice'",
            "value" => "file_voice",
        ]);
        Setting::create([
            "code" => "voice_uri",
            "name" => "voice uri",
            "description" => "Microsoft Andika - Indonesian (Indonesia)",
            "value" => "Microsoft Andika - Indonesian (Indonesia)",
        ]);
        Setting::create([
            "code" => "voice_rate",
            "name" => "voice rate",
            "description" => "number value (0.1 to 10)",
            "value" => "1.5",
        ]);
        Setting::create([
            "code" => "voice_pitch",
            "name" => "voice pitch",
            "description" => "number value (0 to 2)",
            "value" => "2",
        ]);
        Setting::create([
            "code" => "voice_lang",
            "name" => "voice lang",
            "description" => "id-ID",
            "value" => "id-ID",
        ]);

        Setting::create([
            "code" => "work_group_allow",
            "name" => "work group allow",
            "description" => "value array id of work group",
            "value" => "[6]",
        ]);
    }
}
