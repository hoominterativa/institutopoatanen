<?php

namespace App\Models\BlankPages;

use Database\Factories\BlankPages\BAPA01BlankPagesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BAPA01BlankPages extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return BAPA01BlankPagesFactory::new();
    }

    protected $table = "bapa01_blankpages";
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
