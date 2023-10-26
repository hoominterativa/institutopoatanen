<?php

namespace App\Models\Compliances;

use Database\Factories\Compliances\COMP01CompliancesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COMP01Compliances extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COMP01CompliancesFactory::new();
    }

    protected $table = "comp01_compliances";
    protected $fillable = [
        "slug",
        "title_page",
        "title_banner",
        "path_image_desktop_banner",
        "path_image_mobile_banner",
        "background_color_banner",
        "active",
        "sorting",
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
