<?php

namespace App\Models\ContentPages;

use Database\Factories\ContentPages\COPA04ContentPagesFaqTopicsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COPA04ContentPagesFaqTopics extends Model
{
    use HasFactory, SoftDeletes;

    protected static function newFactory()
    {
        return COPA04ContentPagesFaqTopicsFactory::new();
    }

    protected $table = "copa04_contentpages_faqtopics";
    protected $fillable = [
        'title',
        'description',
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
