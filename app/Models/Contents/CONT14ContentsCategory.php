<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT14ContentsCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT14ContentsCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT14ContentsCategoryFactory::new();
    }

    protected $table = "cont14_contents_categories";
    protected $fillable = ['title', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function contents()
    {
        return $this->hasMany(CONT14Contents::class, 'category_id')->active()->sorting();
    }

    public function scopeExists($query)
    {
        return $query->whereExists(function($query){
            $query->select('id')->from('cont14_contents')->whereColumn('cont14_contents.category_id', 'cont14_contents_categories.id');
        });
    }
}
