<?php

namespace App\Models\Topics;

use Database\Factories\Topics\TOPI12TopicsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOPI12Topics extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI12TopicsFactory::new();
    }

    protected $table = "topi12_topics";
    protected $fillable = [
        'title', 'description', 'path_image_icon', 'active', 'sorting'
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
