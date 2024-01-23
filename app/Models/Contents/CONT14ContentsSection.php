<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT14ContentsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT14ContentsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT14ContentsSectionFactory::new();
    }

    protected $table = "cont14_contents_sections";
    protected $fillable = ['title', 'path_image_desktop', 'path_image_mobile', 'background_color', 'active'];



    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }


}
