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
            /*'title' => $this->faker->text(10),
            'path_image' => 'uploads/temp/image_temporary.png',
            'active' => 1,*/
        ];
    }
}
