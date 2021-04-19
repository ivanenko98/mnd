<?php

namespace App\Portal\Models\Roles;

use App\Portal\Models\Roles\Manager\Detail;
use App\Portal\Models\User;

class Manager extends User
{
    protected $table = 'users';

    public function detail()
    {
        return $this->hasOne(Detail::class);
    }
}
