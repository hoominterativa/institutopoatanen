<?php

namespace Database\Factories\Schedules;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Schedules\SCHE01SchedulesBannerShow;

class SCHE01SchedulesBannerShowFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SCHE01SchedulesBannerShow::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'schedule_id' => rand(1,2),
            'title' => $this->faker->text(10),
            'subtitle' => $this->faker->text(10),
            'path_image_desktop' => 'uploads/tmp/image-box.jpg',
            'path_image_mobile' => 'uploads/tmp/gall01_image2.png',
            'active' => 1,
        ];
    }
}
