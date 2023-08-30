<?php

namespace Database\Factories\Contents;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contents\CONT10V2Contents;

class CONT10V2ContentsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CONT10V2Contents::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date('Y-m-d'),
            'title' => $this->faker->text(10),
            'description' => $this->faker->text(30),
            'locale' => 'Salvador-BA',
            'link' => 'http://lorempixel.com',
            'link_target' => '_blank',
            'active' => 1
        ];
    }
}
