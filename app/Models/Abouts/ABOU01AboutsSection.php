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
        "title",
        "subtitle",
        "description",
        "title_button",
        "link_button",
        "target_link_button",
        "path_image_desktop",
        "path_image_mobile",
        "background_color",
        "active",
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
