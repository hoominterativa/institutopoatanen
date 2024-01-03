<?php

namespace Database\Factories\Topics;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Topics\TOPI05Topics;

class TOPI05TopicsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TOPI05Topics::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "title" => $this->faker->text(10),
            "description" => $this->faker->text(100),
            "path_image" => 'uploads/tmp/image-box.jpg',
            "link" => $this->faker->url(),
            "target_link" => '_blank',
            "active" => 1,
        ];
    }
}
