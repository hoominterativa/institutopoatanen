<?php

namespace Database\Factories\Topics;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Topics\TOPI03Topics;

class TOPI03TopicsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TOPI03Topics::class;

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
            'link' => $this->faker->url(),
            'target_link' => '_blank',
            'active' => 1,
        ];
    }
}
