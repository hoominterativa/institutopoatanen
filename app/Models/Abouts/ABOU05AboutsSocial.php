<?php

namespace App\Models\Abouts;

use Database\Factories\Abouts\ABOU05AboutsSocialFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ABOU05AboutsSocial extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ABOU05AboutsSocialFactory::new();
    }

    protected $table = "abou05_abouts_socials";
    protected $fillable = ['content_id', 'link', 'path_image', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function content(){
        return $this->belongsTo(ABOU05AboutsContent::class,'content_id');
    }
}
