<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT13ContentsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT13Contents extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT13ContentsFactory::new();
    }

    protected $table = "cont13_contents";
    protected $fillable = [
        'category_id', 'title', 'subtitle', 'description', 'title_price', 'price', 'title_button',
        'link_button', 'target_link', 'title_featured', 'color_featured', 'featured', 'path_image',
        'active', 'sorting'
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
    }

    public function categories()
    {
        return $this->belongsTo(CONT13ContentsCategory::class, 'category_id');
    }
}
