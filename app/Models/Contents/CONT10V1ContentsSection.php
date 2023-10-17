<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT10V1ContentsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT10V1ContentsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT10V1ContentsSectionFactory::new();
    }

    protected $table = "cont10v1_contents_sections";
    protected $fillable = ['title', 'subtitle', 'path_image_desktop', 'path_image_mobile', 'background_color'];
}
