<?php

namespace App\Models\Services;

use Database\Factories\SERV01ServicesAdvantageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV01ServicesAdvantage extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV01ServicesAdvantageFactory::new();
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
