<?php

namespace App\Models\Account;

use App\Models\Attendance\Event;
use App\Models\Organization\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Guest extends Model
{
    use SoftDeletes,Userstamps;

    protected $table = 'guests';

    public $dates = ['created_at', 'updated_at','deleted_at'];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
