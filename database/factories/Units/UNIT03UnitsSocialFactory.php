<?php

namespace Database\Factories\Units;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Units\UNIT03UnitsSocial;

class UNIT03UnitsSocialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UNIT03UnitsSocial::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'unit_id' => rand(1, 8),
            'link' => $this->faker->url(),
            'target_link' => $this->faker->randomElement('_self', '_blank'),
            'path_image_icon' => 'uploads/tmp/favicon.png',
            'active' => 1,
        ];
    }
}
