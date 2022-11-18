<?php

namespace App\Models\Blogs;

use Database\Factories\Blogs\BLOG01BlogsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BLOG01Blogs extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return BLOG01BlogsFactory::new();
    }

    protected $table = "blog01_blogs";
    protected $fillable = [];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function category()
    {
        return $this->belongsTo(BLOG01BlogsCategory::class, 'category_id');
    }
}
