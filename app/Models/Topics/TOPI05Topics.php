<?php

namespace App\Models\Topics;

use Illuminate\Database\Eloquent\Model;
use Database\Factories\Topics\TOPI05TopicsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TOPI05Topics extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI05TopicsFactory::new();
    }

    protected $table = "topi05_topics";
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
