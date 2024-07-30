<?php

namespace App\Models\ContentPages;

use Database\Factories\ContentPages\COPA04ContentPagesTopicItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COPA04ContentPagesTopicItem extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COPA04ContentPagesTopicItemFactory::new();
    }

    protected $table = "copa04_contentpages_topicitems";
    protected $fillable = [
        'title',
        'text',
        'path_image',
        'active',
        'sorting'
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
