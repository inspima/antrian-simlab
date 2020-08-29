<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class WorkPlace extends Model
{
    use SoftDeletes, Userstamps;

    protected $table = 'work_places';

    public $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
