<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT13ContentsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT13Contents extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT13ContentsFactory::new();
    }

    protected $table = "cont13_contents";
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
