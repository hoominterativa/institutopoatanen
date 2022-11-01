<?php

namespace Database\Factories\Services;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Services\SERV01ServicesAdvantage;

class SERV01ServicesAdvantageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV01ServicesAdvantage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "title" => $this->faker->text(13),
            "description" => $this->faker->text(60),
            "text" => $this->faker->text(300),
            "active" => 1,
            "path_image" => 'uploads/temp/image-box.jpg',
            "path_image_icon" => 'uploads/temp/icon-general.svg',
            "service_id" => rand(1,4),
        ];
    }
}
