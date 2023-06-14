<?php

namespace Database\Factories\Galleries;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Galleries\GALL03Galleries;

class GALL03GalleriesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GALL03Galleries::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $path = $this->faker->randomElement([
            'uploads/tmp/image-box.jpg',
            'uploads/tmp/gall01_image2.png',
            'uploads/tmp/slid01_path_image_desktop.png',
        ]);
        return [
            'title' => $this->faker->text(10),
            'image_legend' => $this->faker->text(10),
            'path_image' => $path,
            'featured' => rand(0, 1),
            'active' => 1,
        ];
    }
}
