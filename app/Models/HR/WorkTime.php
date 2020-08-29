<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class WorkTime extends Model
{
    use SoftDeletes, Userstamps;

    protected $table = 'work_times';
    protected $fillable = ['start_time', 'end_time'];
    public $dates = ['created_at', 'updated_at', 'deleted_at'];
}
