<?php


namespace App\Http\Controllers\Report;

use App\Exports\AttendanceDateRangeExport;
use App\Exports\AttendanceExport;
use App\Http\Controllers\Controller;
use App\Models\Attendance\Attendance;
use App\Models\HR\WorkGroup;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class DateRangeController extends Controller
{
    private $route = "report.date-range.";

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $startDate = date("Y-m-d");
        $data = [
            "route" => $this->route,
            "startDate" => $startDate,
            "endDate" => date('Y-m-d', strtotime($startDate . ' + 30 days')),
            "workGroups" => WorkGroup::all()
        ];
        return view($this->route . 'index', $data);
    }


    public function datatable(Request $request)
    {
        $workGroupId = $request->workGroupId;
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        if ($endDate < $startDate) {
            $endDate = $startDate;
        }

        $startDate = new \DateTime($startDate);
        $endDate = new \DateTime($endDate);
        $endDate->add(new \DateInterval('P1D'));
        $interval = new \DateInterval('P1D');
        $period = new \DatePeriod($startDate, $interval, $endDate);

        $data = User::join("personals", "personals.user_id", "users.id")
            ->join("work_groups", "work_groups.id", "personals.work_group_id")
            ->select("users.id", "users.name", "personals.work_id_number", "users.email", "work_groups.name as work_group_name", "personals.work_group_id");

        if ($workGroupId) {
            $data = $data->where("work_group_id", $workGroupId);
        }
        return DataTables::collection($data->get())
            ->editColumn('detail', function ($d) use ($period) {
                $datum = [];
                foreach ($period as $p) {
                    $date = $p->format("Y-m-d");
                    $attendance = Attendance::where('user_id', $d->id)->where("date", $date)->first();
                    $data = [];
                    $data['shift_name'] = '';
                    $data['work_time'] = '';
                    $data["day"] = 1;
                    $data["date"] = $date;
                    $data["date_in"] = "";
                    $data["date_in"] = "";
                    $data["date_out"] = "";
                    $data["time_in"] = "";
                    $data["time_out"] = "";
                    if ($attendance) {
                        $data['shift_name'] = $attendance->shift_name;
                        if ($attendance->work_time)
                            $data['work_time'] = $attendance->work_time->start_time . " - " . $attendance->work_time->end_time;
                        $data["day"] = 0;
                        if ($attendance->in_time) {
                            $data["date_in"] = Date('d-M-y', strtotime($attendance->in_time));
                            $data["time_in"] = Date('H:i:s', strtotime($attendance->in_time));
                        }
                        if ($attendance->out_time) {
                            $data["date_out"] = Date('d-M-y', strtotime($attendance->out_time));
                            $data["time_out"] = Date('H:i:s', strtotime($attendance->out_time));
                        }
                    }
                    array_push($datum, $data);
                }
                return $datum;
            })
            ->rawColumns(['table'])
            ->make();
    }

    public function excel(Request $request)
    {
        $export = new AttendanceDateRangeExport();
        $export->startDate($request['startDate']);
        $export->endDate($request['endDate']);
        $export->workGroupId($request['workGroupId']);
        return Excel::download($export, 'daterange_attendance_' . $request['startDate'] . '_' . $request['startDate'] . '.xlsx');
    }

}
