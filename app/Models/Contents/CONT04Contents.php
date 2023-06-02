<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT04ContentsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT04Contents extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT04ContentsFactory::new();
    }

    protected $table = "cont04_contents";
    protected $fillable = ['title', 'subtitle', 'description', 'title_button', 'link_button', 'target_link_button', 'path_image'];
}
