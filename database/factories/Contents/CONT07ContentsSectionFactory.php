<?php

namespace Database\Factories\Contents;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contents\CONT07ContentsSection;

class CONT07ContentsSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CONT07ContentsSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title_section' => $this->faker->text(10),
            'subtitle_section' => $this->faker->text(15),
            'title_button' => $this->faker->text(12),
            'link_button' => 'www.youtube.com',
            'target_link_button' => '_blank',
            'path_image_desktop' => 'uploads/tmp/image-box.jpg',
            'path_image_mobile' => 'uploads/tmp/bg-slid-mobile.jpg',
            'background_color' => '#FFFFFF',
            'active' => 1
        ];
    }
}
