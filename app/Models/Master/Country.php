<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Country extends Model
{
    use SoftDeletes, Userstamps;

    protected $table = 'countries';

    public $dates = ['created_at', 'updated_at', 'deleted_at'];
}
