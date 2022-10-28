<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV01ServicesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV01Services extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV01ServicesFactory::new();
    }

    protected $table = "serv01_services";
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
