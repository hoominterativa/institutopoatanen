<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT11ContentsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT11Contents extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT11ContentsFactory::new();
    }

    protected $table = "cont11_contents";
    protected $fillable = ['title', 'subtitle', 'text', 'title_button', 'link_button', 'target_link_button', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function gallery()
    {
        return $this->hasMany(CONT11ContentsGallery::class, 'content_id');
    }
}
