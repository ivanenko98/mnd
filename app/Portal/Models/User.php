<?php

namespace App\Portal\Models;

use App\Portal\Models\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'date_of_birth',
        'about',
        'avatar',
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
     * Set permissions guard to API by default
     * @var string
     */
    protected $guard_name = 'api';

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
//z
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
     * @inheritdoc
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @inheritdoc
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Check if user has a permission
     * @param String
     * @return bool
     */
    public function hasPermission($permission): bool
    {
        foreach ($this->roles as $role) {
            if (in_array($permission, $role->permissions->pluck('name')->toArray())) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        foreach ($this->roles as $role) {
            dd($role->isAdmin());
            if ($role->isAdmin()) {
                return true;
            }
        }

        return false;
    }

    public function skills()
    {
        return $this->belongsToMany(Service::class);
    }
}
