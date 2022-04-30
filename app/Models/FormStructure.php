<?php

namespace App\Models;

use Database\Factories\FormStructureFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormStructure extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return FormStructureFactory::new();
    }

    protected $table = "";

    public function scopeSorting($query)
    {
        return $this->orderBy('sorting', 'ASC');
    }
}
