<?php

namespace Database\Factories\Feedbacks;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Feedbacks\FEED05Feedbacks;

class FEED05FeedbacksFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FEED05Feedbacks::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'testimony' => $this->faker->text(150),
            'classification' => rand(3, 5),
            'path_image' => 'uploads/tmp/guerreiro.png',
            'active' => 1,
        ];
    }
}
