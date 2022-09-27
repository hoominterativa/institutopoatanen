<?php

namespace App\Models\Contents;

use Database\Factories\CONT01ContentsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT01Contents extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT01ContentsFactory::new();
    }

    protected $table = "";

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
