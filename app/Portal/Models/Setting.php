<?php

namespace App\Portal\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeTitle($q, $title)
    {
        return $q->where('title', $title);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
