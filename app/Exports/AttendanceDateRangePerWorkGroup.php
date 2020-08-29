<?php

namespace App\Exports;

use App\Models\Account\Personal;
use App\Models\Attendance\Attendance;
use App\Models\HR\WorkGroup;
use App\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class AttendanceDateRangePerWorkGroup implements FromView, WithTitle
{

    public function __construct(int $workGroupId, string $startDate, string $endDate)
    {
        $this->workGroupId = $workGroupId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        $startDate = $this->startDate;
        $endDate = $this->endDate;
        if ($endDate < $startDate) {
            $endDate = $startDate;
        }
        $startDate = new \DateTime($startDate);
        $endDate = new \DateTime($endDate);
        $endDate->add(new \DateInterval('P1D'));
        $interval = new \DateInterval('P1D');
        $period = new \DatePeriod($startDate, $interval, $endDate);
        $users = User::join("personals", "personals.user_id", "users.id")
            ->join("work_groups", "work_groups.id", "personals.work_group_id")
            ->select("users.id", "users.name", "personals.work_id_number", "users.email", "work_groups.name as work_group_name", "personals.work_group_id");

        if ($this->workGroupId) {
            $users = $users->where("work_group_id", $this->workGroupId);
        }
        $users = $users->get();
        foreach ($users as $user) {
            $datum = [];
            foreach ($period as $p) {
                $date = $p->format("Y-m-d");
                $attendance = Attendance::where('user_id', $user->id)->where("date", $date)->first();
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
                array_push($datum, (object)$data);
            }
            $user->detail = $datum;
        }

        $data = [
            "data" => $users,
        ];
        return view('report.date-range.export', $data);
    }

    public function title(): string
    {
        $workGroup = WorkGroup::find($this->workGroupId);
        return $workGroup->name;
    }
}
