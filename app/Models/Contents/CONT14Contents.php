<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT14ContentsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT14Contents extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT14ContentsFactory::new();
    }

    protected $table = "cont14_contents";
    protected $fillable = ['category_id', 'title', 'description', 'subtitle', 'path_image', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function category()
    {
        return $this->belongsTo(CONT14ContentsCategory::class, 'category_id');
    }
}
