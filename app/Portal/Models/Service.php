<?php

namespace App\Portal\Models;

use App\Portal\Helpers\Acl;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;


class Service extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
