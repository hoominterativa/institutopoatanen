<?php

namespace Database\Factories\Brands;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Brands\BRAN04Brands;

class BRAN04BrandsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BRAN04Brands::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'path_image' => 'uploads/tmp/thumbnail-b.png',
            'path_image_icon' => 'uploads/tmp/favicon.png',
            'link' => $this->faker->url(),
            'active' => 1,
        ];
    }
}
