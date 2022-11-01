<?php

namespace Database\Factories\Services;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Services\SERV01ServicesPortfolio;

class SERV01ServicesPortfolioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV01ServicesPortfolio::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'description' => $this->faker->text(110),
            'active' => 1,
            'path_image' => 'uploads/temp/image-box.jpg',
            'service_id' => rand(1,4),
        ];
    }
}
