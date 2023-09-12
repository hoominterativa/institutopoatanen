<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT13ContentsCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT13ContentsCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT13ContentsCategoryFactory::new();
    }

    protected $table = "cont13_contents_categories";
    protected $fillable = ['slug', 'title', 'path_image', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeExists($query){
        return $query->whereExists(function($query){
            $query->select('id')->from('cont13_contents')->whereColumn('cont13_contents.category_id', 'cont13_contents_categories.id');
        });
    }
}
