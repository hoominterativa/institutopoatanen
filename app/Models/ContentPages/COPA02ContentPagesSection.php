<?php

namespace App\Models\ContentPages;

use Database\Factories\ContentPages\COPA02ContentPagesSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COPA02ContentPagesSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COPA02ContentPagesSectionFactory::new();
    }

    protected $table = "copa02_contentpages_sections";
    protected $fillable =
    [
        //Banner
        'title_banner', 'subtitle_banner', 'path_image_desktop_banner', 'path_image_mobile_banner', 'background_color_banner', 'active_banner',
        //Content
        'title_content', 'subtitle_content', 'description_content', 'path_image_desktop_content', 'path_image_mobile_content', 'background_color_content', 'active_content',
        //Section Topics
        'title_section_topic', 'subtitle_section_topic', 'description_section_topic', 'active_section_topic',
        //Last Section
        'title_last_section', 'subtitle_last_section', 'description_last_section', 'path_image_box_last_section', 'path_image_desktop_last_section', 'path_image_mobile_last_section', 'background_color_last_section', 'title_button_last_section', 'link_button_last_section', 'target_link_button_last_section', 'active_last_section',
    ];

    // public function scopeActiveBanner($query)
    // {
    //     return $query->where('active_banner', 1);
    // }

    // public function ScopeActiveContent($query)
    // {
    //     return $query->where('active_content', 1);
    // }

}
