<?php

namespace Database\Factories\Services;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Services\SERV07ServicesGalleryCategory;

class SERV07ServicesGalleryCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV07ServicesGalleryCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => rand(1,4),
            'path_image' => 'uploads/tmp/thumbnail.png',
        ];
    }
}
