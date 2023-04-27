<?php

namespace App\Models\Abouts;

use Database\Factories\Abouts\ABOU02AboutsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ABOU02AboutsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ABOU02AboutsSectionFactory::new();
    }

    protected $table = "abou02_abouts_sections";
    protected $fillable = ['title', 'description', 'subtitle', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

}
