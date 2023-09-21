<?php

namespace App\Models\Abouts;

use Database\Factories\Abouts\ABOU05AboutsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ABOU05Abouts extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ABOU05AboutsFactory::new();
    }

    protected $table = "abou05_abouts";
    protected $fillable = ['title', 'subtitle', 'text'];
}
