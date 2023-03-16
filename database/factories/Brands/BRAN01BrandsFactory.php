<?php

namespace Database\Factories\Brands;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Brands\BRAN01Brands;

class BRAN01BrandsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BRAN01Brands::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'path_image_box' => 'uploads/tmp/image-box-white.jpg',
            'path_image_icon' => 'uploads/tmp/logo.svg',
            'link' => 'https://www.lipsum.com/',
            'target_link' => '_blank',
            'active' => 1,
            'featured' => 1,
        ];
    }
}
