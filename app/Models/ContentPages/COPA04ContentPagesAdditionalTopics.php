<?php

namespace App\Models\ContentPages;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\ContentPages\COPA04ContentPagesAdditionalTopicsFactory;

class COPA04ContentPagesAdditionalTopics extends Model
{
    use HasFactory, SoftDeletes;

    protected static function newFactory()
    {
        return COPA04ContentPagesAdditionalTopicsFactory::new();
    }

    protected $table = "copa04_contentpages_additionaltopics";
    protected $fillable = [
        'title',
        'link_video',
        'path_image',
        'button_text',
        'button_link',
        'target_link_one',
        'active',
        'sorting',
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
