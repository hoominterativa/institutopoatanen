<?php

namespace Database\Factories\Contents;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contents\CONT12Contents;

class CONT12ContentsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CONT12Contents::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'path_image_icon' => 'uploads/tmp/favicon.png',
            'title_button' => $this->faker->text(10),
            'link_button' => $this->faker->url(),
            'target_link' => '_blank',
            'path_archive' => 'uploads/tmp/guerreiro.png',
            'active' => 1,
        ];
    }
}
