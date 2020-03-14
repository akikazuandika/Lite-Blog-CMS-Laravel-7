<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagModel extends Model
{
    protected $table = 'tags';
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tag_name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at'
    ];
}
