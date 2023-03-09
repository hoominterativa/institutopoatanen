<?php

namespace Database\Factories\Portfolios;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Portfolios\PORT101PortfoliosSection;

class PORT101PortfoliosSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PORT101PortfoliosSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'subtitle' => $this->faker->text(12),
            'path_image_desktop' => 'uploads/temp/image_temporary.png',
            'path_image_mobile' => 'uploads/temp/image_temporary.png',
            'active' => 1,
        ];
    }
}
