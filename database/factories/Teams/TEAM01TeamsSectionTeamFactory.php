<?php

namespace Database\Factories\Teams;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Teams\TEAM01TeamsSectionTeam;

class TEAM01TeamsSectionTeamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TEAM01TeamsSectionTeam::class;

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
