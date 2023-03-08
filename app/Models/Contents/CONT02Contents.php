<?php

namespace App\Models\Contents;

use Database\Factories\CONT02ContentsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT02Contents extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT02ContentsFactory::new();
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
