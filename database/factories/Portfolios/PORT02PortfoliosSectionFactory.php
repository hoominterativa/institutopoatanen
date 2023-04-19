<?php

namespace Database\Factories\Portfolios;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Portfolios\PORT02PortfoliosSection;

class PORT02PortfoliosSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PORT02PortfoliosSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'description' => $this->faker->text(150),
            'path_image_icon' => 'uploads/tmp/icon-general.svg',
            'active' => 1,
        ];
    }
}
