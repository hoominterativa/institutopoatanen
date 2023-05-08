<?php

namespace Database\Factories\Galleries;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Galleries\GALL02GalleriesImage;

class GALL02GalleriesImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GALL02GalleriesImage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'gallery_id' => rand(1, 4),
            'path_image' => 'uploads/tmp/image-box.jpg',
        ];
    }
}
