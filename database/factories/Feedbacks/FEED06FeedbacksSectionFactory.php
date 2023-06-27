<?php

namespace Database\Factories\Feedbacks;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Feedbacks\FEED06FeedbacksSection;

class FEED06FeedbacksSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FEED06FeedbacksSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'title_button' => $this->faker->text(10),
            'link_button' => $this->faker->url(),
            'target_link_button' => '_blank',
            'path_image_desktop' => 'uploads/tmp/bg-boxitem.png',
            'path_image_mobile' => 'uploads/tmp/port01_path_image_box.png',
            'background_color' => '#ffffff',
            'active' => 1
        ];
    }
}
