<?php

namespace App\Models\Topics;

use Database\Factories\Topics\TOPI09TopicsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOPI09Topics extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI09TopicsFactory::new();
    }

    protected $table = "topi09_topics";
    protected $fillable = ['title', 'description', 'path_image_icon', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
