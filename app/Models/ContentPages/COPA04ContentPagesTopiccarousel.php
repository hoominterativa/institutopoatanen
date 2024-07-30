<?php

namespace App\Models\ContentPages;

use Database\Factories\ContentPages\COPA04ContentPagesTopiccarouselFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COPA04ContentPagesTopiccarousel extends Model
{
    use HasFactory, SoftDeletes;

    protected static function newFactory()
    {
        return COPA04ContentPagesTopiccarouselFactory::new();
    }

    protected $table = "copa04_contentpages_topiccarousels";
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'button_text',
        'button_link',
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

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
