<?php

namespace App\Models\Services;

use Database\Factories\SERV01ServicesSubcategoriesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV01ServicesSubcategories extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV01ServicesSubcategoriesFactory::new();
    }

    protected $table = "";

    public function scopeSorting($query)
    {
        return $this->orderBy('sorting', 'ASC');
    }
}
