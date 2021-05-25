<?php

namespace App\Portal\Models;

use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function master()
    {
        return $this->belongsTo(User::class, 'master_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function logs()
    {
        return $this->belongsTo(OrderLog::class);
    }

    protected static function newFactory()
    {
        return OrderFactory::new();
    }
}
