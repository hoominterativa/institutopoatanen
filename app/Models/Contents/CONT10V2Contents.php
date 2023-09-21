<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT10V2ContentsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT10V2Contents extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT10V2ContentsFactory::new();
    }

    protected $table = "cont10v2_contents";
    protected $fillable = ['date', 'title', 'locale', 'description', 'link', 'link_target', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
