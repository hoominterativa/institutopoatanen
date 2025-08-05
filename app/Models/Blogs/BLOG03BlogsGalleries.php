<?php

namespace App\Models\Blogs;

use Illuminate\Database\Eloquent\Model;

class BLOG03BlogsGalleries extends Model
{
    protected $table = "blog03_blogs_galleries";
    protected $fillable = [
        'blog_id',
        'title',
        'path_image',
        'path_image_box',
        'link_url',
        'active',
        'sorting',
    ];

    public function blog()
    {
        return $this->belongsTo(BLOG03Blogs::class, 'blog_id');
    }

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
