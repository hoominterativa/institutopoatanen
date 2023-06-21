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
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'subtitle' => $this->faker->text(10),
            'description' => $this->faker->text(300),
            'information' => $this->faker->text(150),
            'text' => $this->faker->paragraph(3),
            'event_date' => $this->faker->date('Y-m-d'),
            'event_time' => $this->faker->time('H:i:s'),
            'title_button' => $this->faker->text(10),
            'link_button' => $this->faker->url(),
            'target_link_button' => '_blank',
            'path_image' => 'uploads/tmp/gall01_image2.png',
            'path_image_sub' => 'uploads/tmp/favicon.png',
            'path_image_hours' => 'uploads/tmp/favicon.png',
            'active' => 1,
        ];
    }
}
