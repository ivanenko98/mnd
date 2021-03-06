<?php

namespace App\Portal\Models\Roles\Master;

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
    protected $table = 'master_detail';

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
