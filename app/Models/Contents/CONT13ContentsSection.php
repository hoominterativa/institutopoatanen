<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT13ContentsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT13ContentsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT13ContentsSectionFactory::new();
    }

    protected $table = "cont13_contents_sections";
    protected $fillable = [
        'title', 'subtitle', 'path_image', 'path_image_desktop', 'path_image_mobile', 'background_color',
        //Section Topic
        'title_topic', 'description_topic',
        //General
        'active',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
