<?php

namespace App\Portal\Models;

use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class OrderLog extends Model
{
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
