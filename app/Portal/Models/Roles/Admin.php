<?php

namespace App\Portal\Models\Roles;

use App\Portal\Models\Roles\Admin\Detail;
use App\Portal\Models\User;

class Admin extends User
{
    protected $table = 'users';

    public function detail()
    {
        return $this->hasOne(Detail::class);
    }
}
