<?php

namespace App\Models\Account;

use App\Models\HR\Shift;
use App\Models\HR\WorkGroup;
use App\Models\Organization\Company;
use App\Models\Organization\WorkPlace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Personal extends Model
{
    use SoftDeletes, Userstamps;

    protected $table = 'personals';

    public $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function work_place()
    {
        return $this->belongsTo(WorkPlace::class, 'work_place_id');
    }

    public function work_group()
    {
        return $this->belongsTo(WorkGroup::class, 'work_group_id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }
}
