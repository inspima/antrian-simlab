<?php

namespace App\Models\Process;

use App\Models\Master\Organization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class QuotaOrganization extends Model
{
    use SoftDeletes, Userstamps;

    protected $table = 'quota_organizations';

    public $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }
}
