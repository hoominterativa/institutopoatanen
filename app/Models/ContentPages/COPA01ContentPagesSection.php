<?php

namespace App\Models\ContentPages;

use Database\Factories\ContentPages\COPA01ContentPagesSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COPA01ContentPagesSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COPA01ContentPagesSectionFactory::new();
    }

    protected $table = "copa01_contentpages_sections";
    protected $fillable = [
        //Banner
        'title','path_image_desktop','path_image_mobile','background_color','active_banner',
        //Section
        'title_section', 'subtitle_section', 'description_section', 'active_section',
    ];

    public function scopeActiveBanner($query)
    {
        return $query->where('active_banner', 1);
    }

    public function scopeActiveSection($query)
    {
        return $query->where('active_section', 1);
    }

}
