<?php

namespace App\Models\Services;

use Database\Factories\SERV01ServicesCategoriesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV01ServicesCategories extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV01ServicesCategoriesFactory::new();
    }

    protected $table = "";

    public function scopeSorting($query)
    {
        return $this->orderBy('sorting', 'ASC');
    }
}
