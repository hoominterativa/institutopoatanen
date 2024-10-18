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
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'active',
        'sorting',
        'about_id',
        'path_image',
        'title_button',
        'link_button',
        'target_link',
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
