<?php

namespace App\Models\Feedbacks;

use Database\Factories\Feedbacks\FEED06FeedbacksFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FEED06Feedbacks extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return FEED06FeedbacksFactory::new();
    }

    protected $table = "feed06_feedbacks";
    protected $fillable = ['name', 'testimony', 'classification', 'sorting', 'active',];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
