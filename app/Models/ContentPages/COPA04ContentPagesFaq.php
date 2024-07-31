<?php

namespace App\Models\ContentPages;

use Database\Factories\ContentPages\COPA04ContentPagesFaqFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COPA04ContentPagesFaq extends Model
{
    use HasFactory, SoftDeletes;

    protected static function newFactory()
    {
        return COPA04ContentPagesFaqFactory::new();
    }

    protected $table = "copa04_contentpages_faqs";
    protected $fillable = [
        'title',
        'subtitle',
        'color_one',
        'description',
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
