<?php

namespace App\Models\Blogs;

use Database\Factories\BLOG01BlogsCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BLOG01BlogsCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return BLOG01BlogsCategoryFactory::new();
    }

    protected $table = "";
    protected $fillable = [];

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
