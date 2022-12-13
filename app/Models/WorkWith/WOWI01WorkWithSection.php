<?php

namespace App\Models\WorkWith;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\WorkWith\WOWI01WorkWithSectionFactory;

class WOWI01WorkWithSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return WOWI01WorkWithSectionFactory::new();
    }

    protected $table = "wowi01_workwith_sections";
    protected $fillable = [
        "title",
        "subtitle",
        "description",
        "active",
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    // public function getRelationCore()
    // {
    //     return null;
    // }
}
