<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT12ContentsSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT12ContentsSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT12ContentsSectionFactory::new();
    }

    protected $table = "cont12_contents_sections";
    protected $fillable = ['title', 'subtitle', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
