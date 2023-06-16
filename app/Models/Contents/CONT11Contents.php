<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT11ContentsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT11Contents extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT11ContentsFactory::new();
    }

    protected $table = "cont11_contents";
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
