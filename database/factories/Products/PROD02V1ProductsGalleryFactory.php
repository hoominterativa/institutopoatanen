<?php

namespace Database\Factories\Products;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Products\PROD02V1ProductsGallery;

class PROD02V1ProductsGalleryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PROD02V1ProductsGallery::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => rand(1, 8),
            'path_image' => 'uploads/tmp/gall01_image2.png',
        ];
    }
}
