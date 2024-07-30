<?php

namespace App\Models\ContentPages;

use Database\Factories\COPA04ContentPagesTopiccarousel_cardsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COPA04ContentPagesTopiccarousel_cards extends Model
{
    use HasFactory, SoftDeletes;

    protected static function newFactory()
    {
        return COPA04ContentPagesTopiccarousel_cardsFactory::new();
    }

    protected $table = "copa04_contentpages_topiccarousel_cards";
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'path_image',
        'sorting',
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
