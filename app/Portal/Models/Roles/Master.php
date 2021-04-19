<?php

namespace App\Portal\Models\Roles;

use App\Portal\Models\Roles\Master\Detail;
use App\Portal\Models\User;

class Master extends User
{
    protected $table = 'users';

    public function detail()
    {
        return $this->hasOne(Detail::class);
    }
}
