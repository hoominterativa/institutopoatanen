<?php

namespace App\Models\Topics;

use Database\Factories\TOPI13TopicsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOPI13TopicsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI13TopicsSectionFactory::new();
    }

    protected $table = "";
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
