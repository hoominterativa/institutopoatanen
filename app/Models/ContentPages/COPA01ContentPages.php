<?php

namespace App\Models\ContentPages;

use Database\Factories\ContentPages\COPA01ContentPagesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COPA01ContentPages extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COPA01ContentPagesFactory::new();
    }

    protected $table = "copa01_contentpages";
    protected $fillable = [
        'title_page',
        'slug',
        'title_banner',
        'path_image_banner',
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function sections()
    {
        return $this->hasMany(COPA01ContentPagesSection::class, 'contentPage_id', 'id')->with('archives')->sorting();
    }
}
