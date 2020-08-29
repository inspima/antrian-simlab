<?php

namespace App\Exports;

use App\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;

    public function query()
    {
        $date = $this->date;
        return User::leftJoin("attendances", function ($join) use ($date) {
            $join->on("users.id", '=', "attendances.user_id");
            if ($date) {
                $join->on("attendances.date", "=", DB::raw("'" . $date . "'"));
            }
        })->leftJoin("work_times", "work_times.id", "attendances.work_time_id");
    }

    public function map($data): array
    {
        $wt = $data->start_time . " - " . $data->end_time;
        $in = "";
        if ($data->in_time) {
            $in = date("H:i:s", strtotime($data->in_time));
        }

        $out = "";
        if ($data->out_time) {
            $out = date("H:i:s", strtotime($data->out_time));
        }

        $restIn = "";
        if ($data->rest_in_time) {
            $restIn = date("H:i:s", strtotime($data->rest_in_time));
        }

        $restOut = "";
        if ($data->rest_out_time) {
            $restOut = date("H:i:s", strtotime($data->rest_out_time));
        }
        return [
            $data->name,
            $data->email,
            $this->date,
            $wt,
            $in,
            $out,
            $restIn,
            $restOut
        ];
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Date',
            'Work Time',
            'Check In',
            'Check Out',
            'Rest In',
            'Rest Out',
        ];
    }

    public function date(string $date)
    {
        $this->date = $date;
        return $this;
    }
}
