<?php

namespace App\Models\ContentPages;

use Database\Factories\ContentPages\COPA02ContentPagesSectionContentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COPA02ContentPagesSectionContent extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COPA02ContentPagesSectionContentFactory::new();
    }

    protected $table = "copa02_contentpages_sectioncontents";
    protected $fillable = ['title', 'subtitle', 'path_image_desktop', 'path_image_mobile', 'background_color', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
