<?php

namespace Database\Factories\Galleries;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Galleries\GALL02Galleries;

class GALL02GalleriesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GALL02Galleries::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $path = $this->faker->randomElement([
            'uploads/tmp/image-box.jpg',
            'uploads/tmp/image-box-white.jpg'
        ]);
        return [
            'image_legend' => $this->faker->text(15),
            'title' => $this->faker->text(15),
            'subtitle' => $this->faker->text(15),
            'path_image' => $path,
            'active' => 1
        ];
    }
}
