<?php

namespace Database\Factories\Frequently;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Frequently\FREQ01Frequently;

class FREQ01FrequentlyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FREQ01Frequently::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'question' => $this->faker->text(20),
            'answer' => $this->faker->text(200),
            'active' => 1,
        ];
    }
}
