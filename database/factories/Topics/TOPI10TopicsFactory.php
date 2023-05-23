<?php

namespace Database\Factories\Topics;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Topics\TOPI10Topics;

class TOPI10TopicsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TOPI10Topics::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'description' => $this->faker->text(300),
            'path_image_icon' => 'uploads/tmp/favicon.png',
            'path_image_box' => 'uploads/tmp/image-box.jpg',
            'active' => 1,
        ];
    }
}
