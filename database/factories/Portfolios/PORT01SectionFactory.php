<?php

namespace Database\Factories\Portfolios;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Portfolios\PORT01PortfoliosSection;

class PORT01SectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PORT01PortfoliosSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(17),
            'description' => $this->faker->text(100),
            'path_image' => 'uploads/tmp/port01_path_image_section.jpg',
            'active' => 1,
        ];
    }
}
