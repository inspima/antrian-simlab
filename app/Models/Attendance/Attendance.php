<?php

namespace App\Models\Attendance;

use App\Models\HR\WorkTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Attendance extends Model
{
    use SoftDeletes, Userstamps;

    protected $table = 'attendances';

    public $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'user_id',
        'work_time_id',
        'shift_name',
        'in_time',
        'in_pict',
        'in_address',
        'in_lat',
        'in_lng',
        'rest_in_time',
        'rest_out_time',
        'out_time',
        'out_pict',
        'out_address',
        'out_lat',
        'out_lng',
        'date',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function work_time()
    {
        return $this->belongsTo(WorkTime::class, 'work_time_id');
    }
}
