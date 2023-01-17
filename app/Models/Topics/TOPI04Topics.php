<?php

namespace App\Models\Topics;


use Illuminate\Database\Eloquent\Model;
use Database\Factories\Topics\TOPI04TopicsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TOPI04Topics extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI04TopicsFactory::new();
    }

    protected $table = "topi04_topics";
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
