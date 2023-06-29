<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV05ServicesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV05Services extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV05ServicesFactory::new();
    }

    protected $table = "serv05_services";
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
