<?php

namespace App\Models\Attendance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Location extends Model
{
    use SoftDeletes,Userstamps;

    protected $table = 'locations';

    public $dates = ['created_at', 'updated_at','deleted_at'];
}
