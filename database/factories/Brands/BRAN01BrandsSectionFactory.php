<?php

namespace Database\Factories\Brands;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Brands\BRAN01BrandsSection;

class BRAN01BrandsSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BRAN01BrandsSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            /*'title' => $this->faker->text(10),
            'path_image' => 'uploads/temp/image_temporary.png',
            'active' => 1,*/
        ];
    }
}
