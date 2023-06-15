<?php

namespace Database\Factories\Units;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Units\UNIT03UnitsSectionGallery;

class UNIT03UnitsSectionGalleryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UNIT03UnitsSectionGallery::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'subtitle' => $this->faker->text(10),
            'active' => 1
        ];
    }
}
