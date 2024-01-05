<?php

namespace App\Models\Topics;

use Database\Factories\Topics\TOPI102TopicsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOPI102Topics extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI102TopicsFactory::new();
    }

    protected $table = "topi102_topics";
    protected $fillable = ['title', 'subtitle', 'description', 'title_button', 'link_button', 'target_link_button', 'text', 'title_lightbox', 'path_image_box', 'path_image_lightbox', 'path_image_background_lightbox', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

}
