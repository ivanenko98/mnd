<?php

namespace App\Portal\Models\Roles\Admin;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Page
 * @package App
 */
class Detail extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_detail';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
    ];
}
