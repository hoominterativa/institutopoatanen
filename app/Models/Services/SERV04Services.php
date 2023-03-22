<?php

namespace App\Models\Services;

use Illuminate\Database\Eloquent\Model;
use App\Models\Services\SERV04ServicesTopic;
use App\Models\Services\SERV04ServicesCategory;
use Database\Factories\Services\SERV04ServicesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SERV04Services extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return SERV04ServicesFactory::new();
    }

    protected $table = "serv04_services";
    protected $fillable = [
        'title', 'subtitle', 'category_id', 'slug', 'text', 'description', 'path_image', 'path_image_box', 'path_image_icon',
        'background_color', 'featured', 'active', 'sorting',
    ];

    public function scopeSorting($query)
    {
        return $query->orderBy('sorting', 'ASC');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
    }

    public function topics() {
        return $this->hasMany(SERV04ServicesTopic::class, 'service_id')->active()->sorting();
    }

    public function category()
    {
        return $this->belongsTo(SERV04ServicesCategory::class, 'category_id');
    }
}
