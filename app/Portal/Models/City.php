<?php

namespace App\Portal\Models;

use Illuminate\Database\Eloquent\Model;


class City extends Model
{
    protected $guarded = [];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
