<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT10ContentsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT10Contents extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT10ContentsFactory::new();
    }

    protected $table = "cont10_contents";
    protected $fillable = ['title', 'subtitle', 'path_image_desktop', 'path_image_mobile', 'background_color', 'active'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function topics()
    {
        return $this->hasMany(CONT10ContentsTopic::class, 'content_id')->active()->sorting();
    }

}
