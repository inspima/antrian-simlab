<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class WorkDay extends Model
{
    use SoftDeletes, Userstamps;

    protected $table = 'work_days';

    public $dates = ['created_at', 'updated_at', 'deleted_at'];
}
