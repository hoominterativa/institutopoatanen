<?php

namespace App\Models\ContentPages;

use Database\Factories\ContentPages\COPA01ContentPagesSectionArchiveFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COPA01ContentPagesSectionArchive extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COPA01ContentPagesSectionArchiveFactory::new();
    }

    protected $table = "copa01_contentpages_sectionarchives";
    protected $fillable = [
        'contentPage_id', 'title', 'link', 'link_target', 'path_archive', 'sorting', 'active',
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
