<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT04ContentsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT04ContentsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT04ContentsSectionFactory::new();
    }

    protected $table = "cont04_contents_sections";
    protected $fillable = ['title', 'description', 'subtitle', 'path_image_desktop', 'path_image_mobile', 'background_color', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
