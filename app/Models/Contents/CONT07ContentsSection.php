<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT07ContentsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT07ContentsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT07ContentsSectionFactory::new();
    }

    protected $table = "cont07_contents_sections";
    protected $fillable = [
        'title_section', 'subtitle_section', 'link_button', 'title_button', 'target_link_button', 'path_image_desktop', 'path_image_mobile', 'path_image_icon', 'background_color', 'active'
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
