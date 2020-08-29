<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Company extends Model
{
    use SoftDeletes,Userstamps;

    protected $table = 'companies';

    public $dates = ['created_at', 'updated_at','deleted_at'];
}
