<?php

namespace Database\Factories\Units;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Units\UNIT03UnitsGallery;

class UNIT03UnitsGalleryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UNIT03UnitsGallery::class;

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
            'unit_id' => rand(1,8),
            'title' => $this->faker->text(10),
            'path_image' =>  $path,
            'link_video' => 'https://www.youtube.com/embed/SjqZgc9MBf8'
        ];
    }
}
