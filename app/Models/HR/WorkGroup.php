<?php

namespace App\Models\HR;

use App\Models\Organization\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class WorkGroup extends Model
{
    use SoftDeletes,Userstamps;

    protected $table = 'work_groups';

    public $dates = ['created_at', 'updated_at','deleted_at'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }
}
