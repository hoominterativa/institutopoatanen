<?php

namespace App\Models\Blogs;

use Database\Factories\Blogs\BLOG01BlogsCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BLOG01BlogsCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return BLOG01BlogsCategoryFactory::new();
    }

    protected $table = "blog01_blogs_categories";
    protected $fillable = [];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeExists($query)
    {
        return $query->whereExists(function($query){
            $query->select('id')->from('blog01_blogs')->whereColumn('blog01_blogs.category_id', 'blog01_blogs_categories.id');
        });
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
