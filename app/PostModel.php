<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostModel extends Model
{
    protected $table = 'posts';
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_category, title, slug, thumbnail, content, is_public',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at'
    ];

    public function category()
    {
        return $this->belongsTo('App\CategoryModel', 'id_category', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\TagModel', 'post_tags', 'id_post', 'id_tag');
    }
}
