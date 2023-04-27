<?php

namespace App\Models\Abouts;

use Database\Factories\Abouts\ABOU02AboutsLastSectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ABOU02AboutsLastSection extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ABOU02AboutsLastSectionFactory::new();
    }

    protected $table = "abou02_abouts_lastsections";
    protected $fillable = ['title', 'subtitle', 'description', 'path_image', 'title_button', 'link_button', 'target_link_button', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
