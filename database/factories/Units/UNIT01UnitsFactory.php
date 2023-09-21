<?php

namespace Database\Factories\Units;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Units\UNIT01Units;

class UNIT01UnitsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UNIT01Units::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title_unit' => $this->faker->text(10),
            'title' => $this->faker->text(10),
            'description' => $this->faker->text(200),
            'active' => 1,
            'featured' => 1,
        ];
    }
}
