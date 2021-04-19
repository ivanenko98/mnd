<?php

namespace App\Portal\Models\Source;

class Type
{
    const MANAGER = 'manager';
    const MASTER  = 'master';
    const ADMIN  = 'admin';

    public function getOptions()
    {
        return [
            self::MANAGER => 'Manager',
            self::MASTER  => 'Master',
            self::ADMIN  => 'Admin',
        ];
    }

}
