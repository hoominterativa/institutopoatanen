<?php

namespace Database\Factories\Feedbacks;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Feedbacks\FEED01Feedbacks;

class FEED01FeedbacksFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FEED01Feedbacks::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'profession' => $this->faker->jobTitle(),
            'testimony' => $this->faker->text(200),
            'path_image' => 'uploads/tmp/favicon.png',
            'active' => 1,
        ];
    }
}
