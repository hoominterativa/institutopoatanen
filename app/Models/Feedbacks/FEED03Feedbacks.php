<?php

namespace App\Models\Feedbacks;

use Database\Factories\Feedbacks\FEED03FeedbacksFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FEED03Feedbacks extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return FEED03FeedbacksFactory::new();
    }

    protected $table = "feed03_feedbacks";
    protected $fillable = ['name', 'testimony', 'path_image_icon', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
