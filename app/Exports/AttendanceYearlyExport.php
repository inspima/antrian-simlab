<?php

namespace App\Exports;

use App\Models\Account\Personal;
use App\Models\Attendance\Attendance;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class AttendanceYearlyExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {

        $year = $this->year;
        $months = [];
        for ($m = 1; $m <= 12; $m++) {
            $list = array();
            for ($d = 1; $d <= 31; $d++) {
                $time = mktime(12, 0, 0, $m, $d, $year);
                if (date('m', $time) == $m)
                    $list[] = [
                        "date" => date('Y-m-d', $time),
                        "day" => date('j', $time),
                    ];
            }
            $time = mktime(12, 0, 0, $m, 1, $year);
            $months[] = [
                "dates" => $list,
                "month" => date('F', $time)
            ];
        }

        $dataPersonals = Personal::Join("users", "users.id", "personals.user_id")->select("users.name", "user_id")->get();
        foreach ($dataPersonals as $dataPersonal) {
            $attendances = [];
            foreach ($months as $m) {
                foreach ($m["dates"] as $d) {
                    $cek = Attendance::where("date", $d['date'])->where("user_id", $dataPersonal->user_id)->whereNotNull("in_time")->first();
                    $attendances[$d["date"]] = (is_null($cek)) ? 'x' : 'v';
                }
            }
            $dataPersonal->attendances = $attendances;
        }

        $data = [
            "header" => $months,
            "dataPersonals" => $dataPersonals,

        ];
        return view('report.yearly.export', $data);
    }

    public function year(string $year)
    {
        $this->year = $year;
        return $this;
    }
}
