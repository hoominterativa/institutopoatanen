<?php

namespace Database\Factories\Contents;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contents\CONT11Contents;

class CONT11ContentsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CONT11Contents::class;

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
            'text' => $this->faker->text(1000),
            'title_button' => $this->faker->text(6),
            'link_button' => $this->faker->url(),
            'target_link_button' => '_blank',
            'active' => 1,
        ];
    }
}
