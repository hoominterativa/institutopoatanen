<?php

namespace Database\Factories\Contents;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contents\CONT05Contents;

class CONT05ContentsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CONT05Contents::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'subtitle' => $this->faker->text(15),
            'description' => $this->faker->text(500),
            'title_button' => $this->faker->text(8),
            'link_button' => 'https://www.lipsum.com/',
            'target_link_button' => '_blank',
            'active' => 1,
        ];
    }
}
