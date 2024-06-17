<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT05ContentsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT05Contents extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT05ContentsFactory::new();
    }

    protected $table = "cont05_contents";
    protected $fillable = ['title', 'description', 'subtitle', 'title_button', 'link_button', 'target_link_button', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
