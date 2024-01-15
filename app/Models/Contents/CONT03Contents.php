<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT03ContentsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT03Contents extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT03ContentsFactory::new();
    }

    protected $table = "cont03_contents";
    protected $fillable = [
        "title",
        "subtitle",
        "description",
        "title_button",
        "link_button",
        "link_target_button",
        "path_image_center",
        "path_image_right",
        "path_image_background_desktop",
        "path_image_background_mobile",
        "background_color",
        "active",
        "sorting",
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }
}
