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
    protected $fillable = ['title', 'subtitle', 'text', 'path_image'];
}
