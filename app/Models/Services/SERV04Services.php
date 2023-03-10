<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV04ServicesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV04Services extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV04ServicesFactory::new();
    }

    protected $table = "serv04_services";
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
