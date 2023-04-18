<?php

namespace App\Models;

use Database\Factories\CallToActionTitleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallToActionTitle extends Model
{
    use HasFactory;

    protected $table = "call_to_action_titles";
    protected $fillable = [
        "title_header",
        "title_footer",
        "active_header",
        "active_footer",
    ];
}
