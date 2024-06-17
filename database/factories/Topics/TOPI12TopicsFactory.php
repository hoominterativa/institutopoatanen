<?php

namespace Database\Factories\Topics;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Topics\TOPI12Topics;

class TOPI12TopicsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TOPI12Topics::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'description' => $this->faker->text(200),
            'path_image_icon' => 'uploads/tmp/favicon.png',
            'active' => 1,
        ];
    }
}
