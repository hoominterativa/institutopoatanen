<?php

namespace App\Models\Slides;

use Database\Factories\SLID01SlidesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SLID01Slides extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SLID01SlidesFactory::new();
    }

    protected $table = "slid01_slides";
    protected $fillable = ["title","subtitle","description","title_button","link_button","path_image_desktop","path_image_mobile","path_image_png","target_link_button","position_content","active","sorting"];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeactive($query)
    {
        return $query->where('active', 1);
    }
}
