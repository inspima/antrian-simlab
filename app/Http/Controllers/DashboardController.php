<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceYearlyExport;
use App\Models\Account\Personal;
use App\Models\Attendance\Attendance;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [
            "month" => date("Y-m")
        ];
        return view('dashboard.index', $data);
    }

    public function percentage()
    {
        $dateNow = date("Y-m-d");
        $dayNumber = date("N");
        $checkin = Attendance::join("users", "users.id", "attendances.user_id")
            ->join("personals", "personals.user_id", "users.id")
            ->where("date", $dateNow)->count();
        $checkout = Attendance::join("users", "users.id", "attendances.user_id")
            ->join("personals", "personals.user_id", "users.id")
            ->where("date", $dateNow)->whereNotNull("out_time")->count();
        $late = Attendance::join("users", "users.id", "attendances.user_id")
            ->join("personals", "personals.user_id", "users.id")
            ->where("status", 1)
            ->where("date", $dateNow)->count();
        $ontime = Attendance::join("users", "users.id", "attendances.user_id")
            ->join("personals", "personals.user_id", "users.id")
            ->join("work_times", "work_times.id", "attendances.work_time_id")
            ->where("status", 0)
            ->where("date", $dateNow)->count();
        $overtime = Attendance::join("users", "users.id", "attendances.user_id")
            ->join("personals", "personals.user_id", "users.id")
            ->join("work_times", "work_times.id", "attendances.work_time_id")
            ->where("date", $dateNow)
            ->whereRaw("DATE_FORMAT(attendances.out_time,'%H:%i:%s')>concat(work_times.end_time,':00')")->count();
        $data = [
            "employee" => Personal::count(),
            "checkin" => $checkin,
            "checkout" => $checkout,
            "late" => $late,
            "ontime" => $ontime,
            "overtime" => $overtime,
        ];

        return response()->json($data);
    }

    public function grafik(Request $request)
    {
        $list = array();
        if ($request->month) {
            $month = date("m", strtotime($request->month));
            $year = date("Y", strtotime($request->month));
        } else {
            $month = date("m");
            $year = date("Y");
        }

        for ($d = 1; $d <= 31; $d++) {
            $time = mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month)
                $list[] = [
                    "date" => date('j', $time),
                    "full_date" => date('Y-m-d', $time),
                ];
        }

        $data = [];
        foreach ($list as $l) {
            $checkin = Attendance::join("users", "users.id", "attendances.user_id")
                ->join("personals", "personals.user_id", "users.id")
                ->where("date", $l['full_date'])->count();

            $late = Attendance::join("users", "users.id", "attendances.user_id")
                ->join("personals", "personals.user_id", "users.id")
                ->where("status", 1)
                ->where("date", $l['full_date'])->count();

            $checkout = Attendance::join("users", "users.id", "attendances.user_id")
                ->join("personals", "personals.user_id", "users.id")
                ->where("date", $l['full_date'])->whereNotNull("out_time")->count();
            $data[] = [
                "y" => $l["full_date"],
                "a" => $checkin,
                "b" => $late,
                "c" => $checkout,
            ];
        }

        return response()->json($data);
    }
}
