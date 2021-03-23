<?php

namespace App\Portal\Models;

use App\Portal\Models\Manager\Detail;

class Manager extends User
{
    protected $table = 'users';

    public function detail()
    {
        return $this->hasOne(Detail::class);
    }
}
