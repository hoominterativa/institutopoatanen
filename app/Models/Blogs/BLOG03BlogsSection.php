<?php

namespace App\Models\Blogs;

use Database\Factories\Blogs\BLOG03BlogsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BLOG03BlogsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return BLOG03BlogsSectionFactory::new();
    }

    protected $table = "blog03_blogs_sections";
    protected $fillable = ['title', 'subtitle', 'description', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
