<?php

namespace App\Models\Feedbacks;

use Database\Factories\Feedbacks\FEED01FeedbacksFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FEED01Feedbacks extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return FEED01FeedbacksFactory::new();
    }

    protected $table = "feed01_feedbacks";
    protected $fillable = ['name', 'profession', 'testimony', 'path_image', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
