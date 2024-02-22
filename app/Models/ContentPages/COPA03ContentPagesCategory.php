<?php

namespace App\Models\ContentPages;

use Database\Factories\ContentPages\COPA03ContentPagesCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COPA03ContentPagesCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COPA03ContentPagesCategoryFactory::new();
    }

    protected $table = "copa03_contentpages_categories";
    protected $fillable = ['contentPage_id', 'slug', 'title', 'active', 'sorting'];

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
        return $query->whereExists(function($query) {
            $query->select('id')
                ->from('copa03_contentpages_subcategorytopics')
                ->whereColumn('copa03_contentpages_subcategorytopics.category_id', 'copa03_contentpages_categories.id');
        })
        ->orWhereExists(function($query) {
            $query->select('id')
                ->from('copa03_contentpages_subcategoryvideos')
                ->whereColumn('copa03_contentpages_subcategoryvideos.category_id', 'copa03_contentpages_categories.id');
        });
    }
}
