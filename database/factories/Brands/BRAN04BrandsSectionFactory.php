<?php

namespace Database\Factories\Brands;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Brands\BRAN04BrandsSection;

class BRAN04BrandsSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BRAN04BrandsSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'subtitle' => $this->faker->text(10),
            'description' => $this->faker->text(400),
            'active' => 1,
        ];
    }
}
