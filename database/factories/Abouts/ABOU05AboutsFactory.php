<?php

namespace Database\Factories\Abouts;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Abouts\ABOU05Abouts;

class ABOU05AboutsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ABOU05Abouts::class;

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
            'text' => $this->faker->text(999),
        ];
    }
}
