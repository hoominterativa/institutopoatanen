<?php

namespace Database\Factories\Units;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Units\UNIT03UnitsGalleryContent;

class UNIT03UnitsGalleryContentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UNIT03UnitsGalleryContent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'unit_id' => 1,
            'path_image' => 'uploads/tmp/gall01_image2.png',
        ];
    }
}
