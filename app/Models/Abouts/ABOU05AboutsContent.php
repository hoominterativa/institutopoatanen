<?php

namespace App\Models\Abouts;

use Database\Factories\Abouts\ABOU05AboutsContentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ABOU05AboutsContent extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ABOU05AboutsContentFactory::new();
    }

    protected $table = "abou05_abouts_contents";
    protected $fillable = [
        'title', 'text', 'subtitle', 'path_image', 'title_inner', 'text_inner', 'subtitle_inner', 'path_image_inner', 'active', 'sorting'
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function socials(){
        return $this->hasMany(ABOU05AboutsSocial::class, 'content_id');
    }
}
