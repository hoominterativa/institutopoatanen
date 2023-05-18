<?php

namespace App\Models\Portals;

use Database\Factories\POTA01PortalsTagAndPortalFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POTA01PortalsTagAndPortal extends Model
{
    use HasFactory;

    protected $table = "pota01_portals_tagandportals";
    protected $fillable = ['blog_id', 'tag_id'];

}
