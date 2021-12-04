<?php

namespace App\Models\Services;

use Database\Factories\SERV01SectionServicesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV01SectionServices extends Model
{
    use HasFactory;

    protected $table = "serv01section_services";
}
