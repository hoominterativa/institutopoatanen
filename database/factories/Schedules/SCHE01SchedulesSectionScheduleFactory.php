<?php

namespace Database\Factories\Schedules;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Schedules\SCHE01SchedulesSectionSchedule;

class SCHE01SchedulesSectionScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SCHE01SchedulesSectionSchedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'subtitle' => $this->faker->text(10),
            'active' => 1,
        ];
    }
}
