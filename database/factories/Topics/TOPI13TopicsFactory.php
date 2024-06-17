<?php

namespace Database\Factories\Topics;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Topics\TOPI13Topics;

class TOPI13TopicsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TOPI13Topics::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'text' => $this->faker->paragraphs(3, true),
            'title_button' => $this->faker->text(10),
            'link_button' => 'https://www.example.com',
            'target_link' => '_blank',
            'path_image_icon' => 'uploads/tmp/favicon.png',
            'path_image_desktop' => 'uploads/tmp/bg-boxitem-light.png',
            'path_image_mobile' => 'uploads/tmp/port01_path_image_box.png',
            'color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
            'active' => 1,
        ];
    }
}
