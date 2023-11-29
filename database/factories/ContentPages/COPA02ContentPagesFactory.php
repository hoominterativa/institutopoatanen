<?php

namespace Database\Factories\ContentPages;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ContentPages\COPA02ContentPages;

class COPA02ContentPagesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = COPA02ContentPages::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'subtitle' => $this->faker->text(12),
            'description' => $this->faker->text(400),
            'path_image_box' => 'uploads/tmp/image-box.jpg',
            'path_image_desktop' => 'uploads/tmp/image-box-white.jpg',
            'path_image_mobile' => 'uploads/tmp/port01_path_image_box.png',
            'background_color' => '#FFFFFF',
            'title_button' => $this->faker->text(10),
            'link_button' => $this->faker->url(),
            'target_link_button' => '_blank',
            'active' => 1,
        ];
    }
}
