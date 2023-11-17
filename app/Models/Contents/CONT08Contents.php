<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT08ContentsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT08Contents extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT08ContentsFactory::new();
    }

    protected $table = "cont08_contents";
    protected $fillable = ['title', 'subtitle', 'text', 'title_button', 'link_button', 'target_link_button', 'path_image', 'path_image_desktop', 'path_image_mobile', 'background_color'];

}
