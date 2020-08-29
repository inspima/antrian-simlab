<?php

namespace App\Models\HR;

use App\Models\Attendance\Event;
use App\Models\Organization\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Shift extends Model
{
    use SoftDeletes, Userstamps;

    protected $table = 'shifts';

    public $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function shift_details()
    {
        return $this->hasMany(ShiftDetail::class, 'shift_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
