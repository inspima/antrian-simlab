<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class WorkPosition extends Model
{
    use SoftDeletes,Userstamps;

    protected $table = 'work_positions';

    public $dates = ['created_at', 'updated_at','deleted_at'];
}
