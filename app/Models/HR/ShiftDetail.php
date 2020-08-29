<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class ShiftDetail extends Model
{
    use SoftDeletes, Userstamps;

    protected $table = 'shift_details';
    protected $fillable = ['shift_id', 'work_day_id', 'work_time_id'];

    public $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }

    public function work_day()
    {
        return $this->belongsTo(WorkDay::class, 'work_day_id');
    }

    public function work_time()
    {
        return $this->belongsTo(WorkTime::class, 'work_time_id');
    }
}
