<?php

namespace App\Exports;

use App\Models\HR\WorkGroup;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AttendanceDateRangeExport implements WithMultipleSheets
{
    use Exportable;

    public function startDate(string $date)
    {
        $this->startDate = $date;
        return $this;
    }

    public function endDate(string $date)
    {
        $this->endDate = $date;
        return $this;
    }

    public function workGroupId($workGroupId)
    {
        $this->workGroupId = $workGroupId;
        return $this;
    }

    public function sheets(): array
    {
        $workGroups = new WorkGroup();
        if ($this->workGroupId){
            $workGroups = $workGroups->where("id", $this->workGroupId);
        }
        $sheets = [];
        foreach($workGroups->get() as $workGroup){
            $sheets[] = new AttendanceDateRangePerWorkGroup($workGroup->id,  $this->startDate, $this->endDate);
        }

        return $sheets;
    }
}
