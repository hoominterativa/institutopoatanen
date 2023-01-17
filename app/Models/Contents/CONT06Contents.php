<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT06ContentsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT06Contents extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT06ContentsFactory::new();
    }

    protected $table = "cont06_contents";
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
