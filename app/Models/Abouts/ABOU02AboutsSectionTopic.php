<?php

namespace App\Models\Abouts;

use Database\Factories\Abouts\ABOU02AboutsSectionTopicFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ABOU02AboutsSectionTopic extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ABOU02AboutsSectionTopicFactory::new();
    }

    protected $table = "abou02_abouts_sectiontopics";
    protected $fillable = ['title', 'subtitle', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
