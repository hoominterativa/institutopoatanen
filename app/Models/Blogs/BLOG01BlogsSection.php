<?php

namespace App\Models\Blogs;

use Database\Factories\BLOG01BlogsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BLOG01BlogsSection extends Model
{
    protected $table = "blog01_blogs_sections";
    protected $fillable = [
        "title",
        "subtitle",
        "description",
        "active",
        "sorting",
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
