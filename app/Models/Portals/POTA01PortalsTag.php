<?php

namespace App\Models\Portals;

use Database\Factories\Portals\POTA01PortalsTagFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class POTA01PortalsTag extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected static function newFactory()
    {
        return POTA01PortalsTagFactory::new();
    }

    protected $table = "pota01_portals_tags";
    protected $fillable = ['title'];
}
