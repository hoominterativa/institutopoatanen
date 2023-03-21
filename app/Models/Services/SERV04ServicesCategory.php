<?php

namespace App\Models\Services;

use Database\Factories\SERV04ServicesCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV04ServicesCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV04ServicesCategoryFactory::new();
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
