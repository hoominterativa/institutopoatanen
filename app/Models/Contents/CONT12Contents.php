<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT12ContentsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT12Contents extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT12ContentsFactory::new();
    }

    protected $table = "cont12_contents";
    protected $fillable = ['title', 'path_image_icon', 'title_button', 'link_button', 'target_link', 'path_archive', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
