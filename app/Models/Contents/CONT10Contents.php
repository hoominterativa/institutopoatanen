<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT10ContentsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT10Contents extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT10ContentsFactory::new();
    }

    protected $table = "cont10_contents";
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
