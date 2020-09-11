<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Role extends Model
{
    use SoftDeletes, Userstamps;

    protected $table = 'roles';

    public $dates = ['created_at', 'updated_at', 'deleted_at'];
}
