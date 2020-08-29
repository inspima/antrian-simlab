<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class LogError extends Model
{
    use  Userstamps;

    protected $table = 'log_errors';

    protected $fillable = [
        'message',
        'line',
        'params',
        'stack_trace',
        'file',
        'url',
        'ip_source',
        'client_code',
        'user_agent',
        'error_code',
        'http_code',
        'date',
        'time',
    ];

    public $dates = ['created_at', 'updated_at'];
}
