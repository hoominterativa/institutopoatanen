<?php

namespace App\Models\WorkWith;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\WorkWith\WOWI01WorkWithTopicSectionFactory;

class WOWI01WorkWithTopicSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return WOWI01WorkWithTopicSectionFactory::new();
    }

    protected $table = "wowi01_workwith_topicsections";
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
}
