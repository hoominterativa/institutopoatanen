<?php

namespace Database\Factories\Topics;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Topics\TOPI04Topics;

class TOPI04TopicsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TOPI04Topics::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "title_topic" => $this->faker->text(15),
            "title" => $this->faker->text(10),
            "subtitle" => $this->faker->text(12),
            "description" => $this->faker->text(200),
            "path_image" => 'uploads/tmp/image-box.jpg',
            "title_button" => $this->faker->text(8),
            "link_button" => 'www.example.com',
            "target_link_button" => '_blank',
            "active" => 1,
        ];
    }
}
