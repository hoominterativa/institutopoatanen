<?php

namespace App\Models\ContentPages;

use Database\Factories\ContentPages\COPA02ContentPagesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COPA02ContentPages extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COPA02ContentPagesFactory::new();
    }

    protected $table = "copa02_contentpages";
    protected $fillable = [];

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
