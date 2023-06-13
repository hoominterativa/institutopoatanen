<?php

namespace App\Models\Topics;

use Database\Factories\TOPI09TopicsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOPI09Topics extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI09TopicsFactory::new();
    }

    protected $table = "topi10_topics";
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
