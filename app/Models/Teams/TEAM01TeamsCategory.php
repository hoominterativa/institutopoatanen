<?php

namespace App\Models\Teams;

use Database\Factories\TEAM01TeamsCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TEAM01TeamsCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TEAM01TeamsCategoryFactory::new();
    }

    protected $table = "";
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
