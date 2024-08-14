<?php

namespace Database\Factories\Schedules;

use Illuminate\Support\Str;
use App\Models\Schedules\SCHE01Schedules;
use Illuminate\Database\Eloquent\Factories\Factory;

class SCHE01SchedulesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SCHE01Schedules::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $title = $this->faker->text(25);
        $subtitle = $this->faker->text(10);
        return [
            //Schedule
            'title' => $title,
            'slug' => Str::slug($title. ' ' .$subtitle),
            'subtitle' => $subtitle,
            'description' => $this->faker->text(300),
            'description_box' => $this->faker->text(100),
            'information' => $this->faker->text(150),
            'text' => $this->faker->paragraph(3),
            'event_date' => $this->faker->date('Y-m-d'),
            'event_time' => $this->faker->time('H:i:s'),
            'title_button' => $this->faker->text(10),
            'link_button' => $this->faker->url(),
            'target_link_button' => '_blank',
            'path_image' => 'uploads/tmp/gall01_image2.png',
            'path_image_box' => 'uploads/tmp/gall01_image2.png',
            'path_image_sub' => 'uploads/tmp/favicon.png',
            'path_image_hours' => 'uploads/tmp/favicon.png',
            'active' => 1,
            'featured' => rand(0,1),
            //Banner inner
            'title_banner' => $this->faker->text(10),
            'subtitle_banner' => $this->faker->text(10),
            'path_image_desktop_banner' => 'uploads/tmp/image-box.jpg',
            'path_image_mobile_banner' => 'uploads/tmp/gall01_image2.png',
            'active_banner' => 1,
        ];
    }
}
