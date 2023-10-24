<?php

namespace Database\Factories\Portfolios;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Portfolios\PORT04PortfoliosAdditionalTopic;

class PORT04PortfoliosAdditionalTopicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PORT04PortfoliosAdditionalTopic::class;

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
