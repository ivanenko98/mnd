<?php

namespace App\Portal\Models;

use App\Portal\Helpers\Acl;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;


class Service extends Model
{
    protected $guarded = [];

    public function child()
    {
        return $this->belongsTo(Service::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Service::class, 'parent_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
