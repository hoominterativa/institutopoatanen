<?php

namespace App\Models\Portfolios;

use Database\Factories\PORT01SectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PORT01PortfoliosSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return PORT01SectionFactory::new();
    }

    protected $table = "port01_portfolios_sections";
    protected $fillable = ["title","description","title_internal","subtitle_internal","description_internal"];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC')->orderBy('title', 'ASC');
    }
}
