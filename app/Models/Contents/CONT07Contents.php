<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT07ContentsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT07Contents extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT07ContentsFactory::new();
    }

    protected $table = "cont07_contents";
    protected $fillable = ['link_video', 'path_image', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
