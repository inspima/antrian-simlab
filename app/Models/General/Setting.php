<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Setting extends Model
{
    use  Userstamps;

    protected $table = 'settings';

    public $dates = ['created_at', 'updated_at'];

}
