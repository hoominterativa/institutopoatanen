<?php

namespace App\Models\Services;

use Database\Factories\Services\SERV09ServicesFeedbackFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERV09ServicesFeedback extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV09ServicesFeedbackFactory::new();
    }

    protected $table = "serv09_services_feedback";
    protected $fillable = ['service_id', 'name', 'profession', 'text', 'path_image', 'active', 'sorting'];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
