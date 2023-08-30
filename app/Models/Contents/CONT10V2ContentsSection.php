<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT10V2ContentsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT10V2ContentsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT10V2ContentsSectionFactory::new();
    }

    protected $table = "cont10v2_contents_sections";
    protected $fillable = ['title', 'subtitle', 'path_image_desktop', 'path_image_mobile', 'background_color', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

}
