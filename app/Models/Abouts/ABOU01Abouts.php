<?php

namespace App\Models\Abouts;


use Illuminate\Database\Eloquent\Model;
use Database\Factories\Abouts\ABOU01AboutsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ABOU01Abouts extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ABOU01AboutsFactory::new();
    }

    protected $table = "abou01_abouts";
    protected $fillable = [
        "title",
        "subtitle",
        "text",
        "path_image",
        "path_image_desktop",
        "path_image_mobile",
        "background_color",
    ];
}
