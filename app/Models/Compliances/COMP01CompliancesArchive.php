<?php

namespace App\Models\Compliances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COMP01CompliancesArchive extends Model
{
    use HasFactory;

    protected $table = "comp01_compliances_archives";
    protected $fillable = [
        "compliance_id",
        "title",
        "path_archive",
        "sorting",
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }
}
