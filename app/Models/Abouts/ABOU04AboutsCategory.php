<?php

namespace App\Models\Abouts;

use Database\Factories\Abouts\ABOU04AboutsCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ABOU04AboutsCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ABOU04AboutsCategoryFactory::new();
    }

    protected $table = "abou04_abouts_categories";
    protected $fillable = ['about_id', 'title', 'description', 'slug', 'sorting', 'active'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeExists($query)
    {
        return $query->whereExists(function($query){
            $query->select('id')->from('abou04_abouts_galleries')->whereColumn('abou04_abouts_galleries.category_id', 'abou04_abouts_categories.id');
        });
    }

    public function galleries()
    {
        return $this->hasMany(ABOU04AboutsGallery::class, 'category_id');
    }

}
