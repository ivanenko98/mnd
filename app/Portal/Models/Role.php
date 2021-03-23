<?php

namespace App\Portal\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Page
 * @package App
 */
class Role extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Get role id from role name.
     *
     * @param $name
     * @return bool
     */
    public static function getIdFromName($name)
    {
        return self::where('name', $name)->first()->id ?? false;
    }

    /**
     * @param $id
     * @return bool
     */
    public static function getNameFromId($id)
    {
        return self::find($id)->name ?? false;
    }
}
