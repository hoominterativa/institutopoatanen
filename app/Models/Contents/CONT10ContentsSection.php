<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT10ContentsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT10ContentsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT10ContentsSectionFactory::new();
    }

    protected $table = "cont10_contents_sections";
    protected $fillable = ['title', 'subtitle', 'path_image_desktop', 'path_image_mobile', 'background_color', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

}
