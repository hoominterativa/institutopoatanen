<?php

namespace App\Models\ContentPages;

use Database\Factories\ContentPages\COPA04ContentPagesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class COPA04ContentPages extends Model
{
    use HasFactory, SoftDeletes;

    protected static function newFactory()
    {
        return COPA04ContentPagesFactory::new();
    }

    protected $table = "copa04_contentpages";
    protected $fillable = [
        'title_page',
        'sorting',
        'active',
        'slug'
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
