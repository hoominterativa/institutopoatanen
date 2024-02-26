<?php

namespace Database\Factories\ContentPages;

use Illuminate\Support\Str;
use App\Models\ContentPages\COPA03ContentPages;
use Illuminate\Database\Eloquent\Factories\Factory;

class COPA03ContentPagesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = COPA03ContentPages::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title_page = $this->faker->text(10);

        return [
            'slug' => Str::slug($title_page),
            'title_page' =>  $title_page,
            'title_topic_section' => $this->faker->text(10),
            'subtitle_topic_section' => $this->faker->text(10),
            'title_video_section' => $this->faker->text(10),
            'subtitle_video_section' => $this->faker->text(10),
            'path_image_banner_desktop' => 'uploads/tmp/image-box.jpg',
            'path_image_banner_mobile' => 'uploads/tmp/thumbnail.png',
            'background_color_banner' => '#FFFFFF',
            'active' => 1,
        ];
    }
}
