<?php

namespace App\Models\Slides;

use Database\Factories\SLID01SlidesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SLID01Slides extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SLID01SlidesFactory::new();
    }

    protected $table = "";

    public function scopeSorting($query)
    {
        return $this->orderBy('sorting', 'ASC');
    }
}
