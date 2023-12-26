<?php

namespace Database\Factories\Topics;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Topics\TOPI01Topics;

class TOPI01TopicsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TOPI01Topics::class;

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
            'link' => $this->faker->url(),
            'target_link' => '_blank',
            'path_image_icon' => 'uploads/tmp/favicon.png',
            'path_image' => 'uploads/tmp/image-box.jpg',
            'active' => 1,
        ];
    }
}
