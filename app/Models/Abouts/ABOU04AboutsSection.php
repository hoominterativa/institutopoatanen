<?php

namespace App\Models\Abouts;

use Database\Factories\Abouts\ABOU04AboutsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ABOU04AboutsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ABOU04AboutsSectionFactory::new();
    }

    protected $table = "abou04_abouts_sections";
    protected $fillable = ['title', 'subtitle', 'description', 'path_image', 'path_image_desktop', 'path_image_mobile', 'background_color', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
