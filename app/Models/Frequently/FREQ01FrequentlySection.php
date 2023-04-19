<?php

namespace App\Models\Frequently;

use Database\Factories\Frequently\FREQ01FrequentlySectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FREQ01FrequentlySection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return FREQ01FrequentlySectionFactory::new();
    }

    protected $table = "freq01_frequently_sections";
    protected $fillable = ['title', 'subtitle', 'path_image_desktop', 'path_image_mobile', 'background_color', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
