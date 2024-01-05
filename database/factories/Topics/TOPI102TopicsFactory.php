<?php

namespace Database\Factories\Topics;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Topics\TOPI102Topics;

class TOPI102TopicsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TOPI102Topics::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'title_lightbox' => $this->faker->text(10),
            'subtitle' => $this->faker->text(10),
            'description' => $this->faker->text(200),
            'text' => $this->faker->text(600),
            'title_button' => $this->faker->text(7),
            'link_button' => $this->faker->url(),
            'target_link_button' => '_blank',
            'path_image_box' => $this->faker->randomElement(['uploads/tmp/image-box.jpg', 'uploads/tmp/gall01_image1.png', 'uploads/tmp/thumbnail.png']),
            'path_image_background_lightbox' => 'uploads/tmp/bg-boxitem-light.png',
            'path_image_lightbox' => 'uploads/tmp/gall01_image2.png',
            'active' => 1,
        ];
    }
}
