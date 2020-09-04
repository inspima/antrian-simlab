<?php

namespace App\Models\Process;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Registration extends Model
{
    use SoftDeletes, Userstamps;

    protected $table = 'registrations';

    public $dates = ['created_at', 'updated_at', 'deleted_at'];
}
