<?php

namespace App\Models\Abouts;

use Database\Factories\ABOU02AboutsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ABOU02Abouts extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ABOU02AboutsFactory::new();
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
