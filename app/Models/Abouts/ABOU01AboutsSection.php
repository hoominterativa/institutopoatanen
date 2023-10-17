<?php

namespace App\Models\Abouts;

use Database\Factories\Abouts\ABOU01AboutsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ABOU01AboutsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ABOU01AboutsSectionFactory::new();
    }

    protected $table = "abou01_abouts_sections";
    protected $fillable = [
        "title_section",
        "subtitle_section",
        "description_section",
        "title_banner",
        "subtitle_banner",
        "path_image_banner",
        "title_inner_section",
        "subtitle_inner_section",
        "path_image_inner_section",
        "path_image_section_desktop",
        "path_image_section_mobile",
        "text_inner_section",
        "background_color",
    ];
}
