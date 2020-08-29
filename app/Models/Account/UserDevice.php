<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class UserDevice extends Model
{
    use SoftDeletes, Userstamps;

    protected $table = 'user_devices';

    public $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'user_id',
        'manufacture',
        'brand',
        'model',
        'imei',
        'serial',
        'device_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
