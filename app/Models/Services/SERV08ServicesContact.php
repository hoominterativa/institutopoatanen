<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV08ServicesContactFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV08ServicesContact extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV08ServicesContactFactory::new();
    }

    protected $table = "serv08_services_contacts";
    protected $fillable = ['compliance_id', 'unit_id', 'title', 'description', 'title_button', 'inputs_form', 'email_form', 'active'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
