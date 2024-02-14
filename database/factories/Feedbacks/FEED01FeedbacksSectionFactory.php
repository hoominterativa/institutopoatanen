<?php

namespace Database\Factories\Feedbacks;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Feedbacks\FEED01FeedbacksSection;

class FEED01FeedbacksSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FEED01FeedbacksSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'active' => 1,
        ];
    }
}
