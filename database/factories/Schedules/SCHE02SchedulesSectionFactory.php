<?php

namespace Database\Factories\Schedules;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Schedules\SCHE02SchedulesSection;

class SCHE02SchedulesSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SCHE02SchedulesSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title_section' => $this->faker->text(10),
            'subtitle_section' => $this->faker->text(10),
            'description_section' => $this->faker->text(300),
            'path_image_section' => 'uploads/tmp/image-pmg.png',
            'path_image_desktop_section' => 'uploads/tmp/gall01_image2.png',
            'path_image_mobile_section' => 'uploads/tmp/port01_path_image_box.png',
            'background_color_section' => '#FFFFFF',
            'title_banner' => $this->faker->text(10),
            'subtitle_banner' => $this->faker->text(10),
            'path_image_banner' => 'uploads/tmp/logo-for.png',
            'path_image_desktop_banner' => 'uploads/tmp/gall01_image2.png',
            'path_image_mobile_banner' => 'uploads/tmp/port01_path_image_box.png',
            'background_color_banner' => '#FFFFFF',
        ];
    }
}
