<?php

namespace App\Models\Blogs;

use Database\Factories\Blogs\BLOG03BlogsCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BLOG03BlogsCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return BLOG03BlogsCategoryFactory::new();
    }

    protected $table = "blog03_blogs_categories";
    protected $fillable = [
        "title",
        "slug",
        "active",
        "sorting",
    ];

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
            $query->select('id')->from('blog03_blogs')->whereColumn('blog03_blogs.category_id', 'blog03_blogs_categories.id');
        });
    }

    // DROPDOW MENU

    public function scopeExistsRegister($query)
    {
        return $query->whereExists(function($query){
            $query->select('id')->from('blog03_blogs')->whereColumn('blog03_blogs.category_id', 'blog03_blogs_categories.id');
        });
    }
}
