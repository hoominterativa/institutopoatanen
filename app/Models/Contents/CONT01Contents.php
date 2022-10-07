<?php

namespace App\Models\Contents;

use Database\Factories\Contents\CONT01ContentsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CONT01Contents extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return CONT01ContentsFactory::new();
    }

    protected $table = "cont01_contents";
    protected $fillable = ["title","subtitle","link","target_link","path_image"];
}
