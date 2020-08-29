<?php

namespace App\Models\Attendance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Event extends Model
{
    use SoftDeletes,Userstamps;

    protected $table = 'events';

    public $dates = ['created_at', 'updated_at','deleted_at'];
}
