<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Holiday extends Model
{
    use SoftDeletes, Userstamps;

    protected $table = 'holidays';

    public $dates = ['created_at', 'updated_at', 'deleted_at'];
}
