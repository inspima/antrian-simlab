<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class LogError extends Model
{
    use SoftDeletes, Userstamps;

    protected $table = 'log_errors';

    public $dates = ['created_at', 'updated_at', 'deleted_at'];
}
