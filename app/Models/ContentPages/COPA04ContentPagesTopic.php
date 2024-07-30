<?php

namespace App\Models\ContentPages;

use Database\Factories\ContentPages\COPA04ContentPagesTopicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COPA04ContentPagesTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COPA04ContentPagesTopicFactory::new();
    }

    protected $table = "copa04_contentpages_topics";
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'active'
    ];
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
