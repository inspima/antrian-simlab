<?php

namespace App\Http\Controllers\Report;

use App\Exports\AttendanceExport;
use App\Exports\AttendanceYearlyExport;
use App\Http\Controllers\Controller;
use App\Models\Account\Personal;
use App\Models\Attendance\Attendance;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class YearlyController extends Controller
{
    private $route = 'report.yearly.';

    public function index(Request $request)
    {
        if ($request->year) {
            $year = $request->year;
        } else {
            $year = date("Y");
        }

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
            "year" => $year,

        ];
//        dd($data);
        return view($this->route . 'index', $data);
    }

    public function data(Request $request)
    {
        $date = "";

        $list = array();
        $month = 7;
        $year = 2020;

        for ($d = 1; $d <= 31; $d++) {
            $time = mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month)
                $list[] = date('Y-m-d', $time);
        }


        $dataPersonals = Personal::Join("users", "users.id", "personals.user_id")->select("users.name")->get();
        foreach ($dataPersonals as $dataPersonal) {
            $attendances = [];
            foreach ($list as $l) {
                $cek = Attendance::where("date", $l)->whereNotNull("in_time")->first();
                $attendances[$l] = (is_null($cek)) ? 'x' : 'v';
            }
            $dataPersonal->attendances = $attendances;
        }

        return response()->json($dataPersonals);
    }

    public function header(Request $request)
    {
        $date = "";

        $list = array();
        $month = 7;
        $year = 2020;

        for ($d = 1; $d <= 31; $d++) {
            $time = mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month)
                $list[] = [
                    "date" => date('Y-m-d', $time),
                    "day" => date('d', $time),
                ];
        }
        return response()->json($list);
    }

    public function excel(Request $request)
    {
        $export = new AttendanceYearlyExport();
        $export->year($request['year']);
        return Excel::download($export, 'yearly_attendance_' . $request['year'] . '.xlsx');
    }
}
