<?php

namespace Database\Factories\Services;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Services\SERV01ServicesPortfolioSection;

class SERV01ServicesPortfolioSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV01ServicesPortfolioSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(15),
            'subtitle' => $this->faker->text(10),
            'description' => $this->faker->text(280),
            'active' => 1,
            "service_id" => rand(1,4),
        ];
    }
}
