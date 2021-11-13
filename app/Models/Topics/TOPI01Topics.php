<?php

namespace App\Models\Topics;

use Database\Factories\TOPI01TopicsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TOPI01Topics extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TOPI01TopicsFactory::new();
    }

    protected $table = "topi01_topics";

    public function scopeSorting($query)
    {
        return $this->orderBy('sorting', 'ASC');
    }


}
