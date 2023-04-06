<?php

namespace Database\Factories\Contents;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contents\CONT10Contents;

class CONT10ContentsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CONT10Contents::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => date('Y-m-d'),
            'title' => $this->faker->text(10),
            'locale' => 'Salvador-BA',
            'link' => 'http://lorempixel.com',
            'link_target' => '_blank',
            'active' => 1
        ];
    }
}
