<?php

namespace Database\Factories\Services;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Services\SERV05ServicesGalleryService;

class SERV05ServicesGalleryServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV05ServicesGalleryService::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'service_id' => rand(1,12),
            'path_image_desktop' => 'uploads/tmp/thumbnail.png',
            'path_image_mobile' => 'uploads/tmp/thumbnail-b.png',
        ];
    }
}
