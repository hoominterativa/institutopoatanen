<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT02V2ContentsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT02V2Contents extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT02V2ContentsFactory::new();
    }

    protected $table = "cont02v2_contents";
    protected $fillable = [
        'title', 'subtitle', 'description', 'title_button', 'link_button', 'target_link_button',
        'path_image_background_desktop', 'path_image_background_mobile', 'path_image', 'active', 'sorting'
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
