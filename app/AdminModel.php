<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
{
    protected $table = 'admins';
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'level',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'updated_at'
    ];
}
