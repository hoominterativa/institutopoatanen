<?php

namespace App\Models\Compliances;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\Compliances\COMP01CompliancesSectionFactory;

class COMP01CompliancesSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return COMP01CompliancesSectionFactory::new();
    }

    protected $table = "comp01_compliances_sections";
    protected $fillable = [
        "compliance_id",
        "title",
        "subtitle",
        "path_image_icon",
        "text",
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

    public function archives()
    {
        return $this->hasMany(COMP01CompliancesArchive::class, 'section_id','id')->sorting();
    }
}
