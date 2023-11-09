<?php

namespace Database\Factories\Abouts;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Abouts\ABOU04AboutsGallery;

class ABOU04AboutsGalleryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ABOU04AboutsGallery::class;

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
            'about_id' => rand(1,2),
            'title' => $this->faker->text(10),
            'path_image' => $path,
            'active' => 1,
        ];
    }
}
