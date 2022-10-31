<?php

namespace Database\Factories\Services;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Services\SERV01Services;

class SERV01ServicesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV01Services::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "title" => $this->faker->text(6),
            "subtitle" => $this->faker->text(9),
            "description" => $this->faker->text(60),
            "text" => $this->faker->text(900),
            "active" => 1,
            "featured" => 1,
            "path_image" => "uploads/tmp/image-box.jpg",
            "path_image_icon" => "uploads/tmp/icon-general.svg",
        ];
    }
}
