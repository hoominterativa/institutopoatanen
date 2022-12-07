<?php

namespace App\Models\ContentPages;

use Database\Factories\ContentPages\COPA01ContentPagesSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COPA01ContentPagesSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COPA01ContentPagesSectionFactory::new();
    }

    protected $table = "copa01_contentpages_sections";
    protected $fillable = [
        'contentPage_id',
        'title',
        'subtitle',
        'path_image_icon',
        'text',
        'active',
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function archives()
    {
        return $this->hasMany(COPA01ContentPagesSectionArchive::class, 'section_id', 'id')->sorting();
    }
}
