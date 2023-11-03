<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT13ContentsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT13Contents extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT13ContentsFactory::new();
    }

    protected $table = "cont13_contents";
    protected $fillable = ['title', 'subtitle', 'text', 'link', 'path_image', 'path_image_desktop', 'path_image_mobile', 'background_color', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function galleries()
    {
        return $this->hasMany(CONT13ContentsGallery::class, 'content_id');
    }
}
