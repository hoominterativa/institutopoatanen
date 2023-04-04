<?php

namespace Database\Factories\Galleries;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Galleries\GALL01Galleries;

class GALL01GalleriesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GALL01Galleries::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'path_image' => 'uploads/tmp/gall01_image2.png',
            'active' => 1,
        ];
    }
}
