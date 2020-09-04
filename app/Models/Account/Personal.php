<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Personal extends Model
{
    use SoftDeletes, Userstamps;

    protected $table = 'personals';

    public $dates = ['created_at', 'updated_at', 'deleted_at'];
}
