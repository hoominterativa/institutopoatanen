<?php

namespace Database\Factories\Portfolios;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Portfolios\PORT05PortfoliosTestimonial;

class PORT05PortfoliosTestimonialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PORT05PortfoliosTestimonial::class;

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
