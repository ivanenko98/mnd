<?php

namespace App\Portal\Models;

use App\Portal\Models\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Check is non verified.
     *
     * @return bool
     */
//    public function isNonVerified()
//    {
//        return $this->role_id == Role::getIdFromName('non_verified');
//    }

    /**
     * Check is online.
     *
     * @return bool
     */
//    public function isOnline()
//    {
//        $lastActivityTime = \Carbon\Carbon::now()->diffInMinutes($this->last_activity);
//
//        return $lastActivityTime < env('ONLINE_TIME', 5);
//    }

    /**
     * Get user full name
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get user avatar
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
//    public function avatar()
//    {
//        return $this->morphOne(Attachment::class, 'attachmentable')
//            ->where('type', 'image')
//            ->where('status', 'avatar');
//    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
