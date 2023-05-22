<?php

namespace App\Models\Topics;

use Database\Factories\Topics\TOPI03TopicsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOPI03Topics extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI03TopicsFactory::new();
    }

    protected $table = "topi03_topics";
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
