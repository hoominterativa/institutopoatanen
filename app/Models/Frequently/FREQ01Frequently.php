<?php

namespace App\Models\Frequently;

use Database\Factories\Frequently\FREQ01FrequentlyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FREQ01Frequently extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return FREQ01FrequentlyFactory::new();
    }

    protected $table = "freq01_frequently";
    protected $fillable = ['question', 'answer', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
