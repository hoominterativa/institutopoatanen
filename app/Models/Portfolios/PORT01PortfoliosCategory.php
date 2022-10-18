<?php

namespace App\Models\Portfolios;

use Database\Factories\PORT01CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT01PortfoliosCategory extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT01CategoryFactory::new();
    }

    protected $table = "port01_portfolios_categories";
    protected $fillable = ["title","slug","path_image_icon","view_menu","featured","active","sorting"];

    public function scopeActive($query)
    {
        return $query->where('active', 1)->where('featured', 1);
    }

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeExists($query)
    {
        return $query->whereExists(function($query){
            $query->select('id')->from('port01_portfolios')->whereRaw('port01_portfolios.category_id = port01_portfolios_categories.id');
        });
    }

    public function subcategories()
    {
        return $this->belongsToMany(PORT01PortfoliosSubategory::class, 'port01_portfolios','category_id','subcategory_id')->groupBy('category_id');
    }

    // DROPDOW MENU

    public function scopeExistsRegister($query)
    {
        return $query->whereExists(function($query){
            $query->select('id')->from('port01_portfolios')->whereRaw('port01_portfolios.category_id = port01_portfolios_categories.id');
        });
    }

    public function getRelationCore()
    {
        return $this->belongsToMany(PORT01PortfoliosSubategory::class, 'port01_portfolios','category_id','subcategory_id')->groupBy('category_id');
    }
}
