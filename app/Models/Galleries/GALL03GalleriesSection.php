<?php

namespace App\Models\Galleries;

use Database\Factories\Galleries\GALL03GalleriesSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GALL03GalleriesSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return GALL03GalleriesSectionFactory::new();
    }

    protected $table = "gall03_galleries_sections";
    protected $fillable = ['title', 'subtitle', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
