<?php

namespace App\Models\Abouts;

use Database\Factories\Abouts\ABOU04AboutsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ABOU04Abouts extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ABOU04AboutsFactory::new();
    }

    protected $table = "abou04_abouts";
    protected $fillable = ['slug', 'title', 'subtitle', 'text', 'path_image', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
