<?php

namespace App\Models\Abouts;

use Database\Factories\Abouts\ABOU02AboutsTopicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ABOU02AboutsTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ABOU02AboutsTopicFactory::new();
    }

    protected $table = "abou02_abouts_topics";
    protected $fillable = ['title', 'subtitle', 'description', 'text', 'path_image', 'active', 'sorting', 'about_id', 'featured'];

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
}
