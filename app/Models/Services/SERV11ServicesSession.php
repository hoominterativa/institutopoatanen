<?php

namespace App\Models\Services;

use Database\Factories\SERV11ServicesSessionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV11ServicesSession extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV11ServicesSessionFactory::new();
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
