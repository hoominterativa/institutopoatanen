<?php

namespace App\Models\Topics;

use Database\Factories\Topics\TOPI101TopicsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOPI101Topics extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI101TopicsFactory::new();
    }

    protected $table = "topi101_topics";
    protected $fillable = ['description', 'path_image', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
