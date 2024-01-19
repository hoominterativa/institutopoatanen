<?php

namespace Database\Factories\Units;

use Illuminate\Support\Str;
use App\Models\Units\UNIT01UnitsCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class UNIT01UnitsCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UNIT01UnitsCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(10);

        return [
            'slug' => Str::slug($title),
            'title' => $title,
            'path_image' => 'uploads/tmp/favicon.png',
            'active' => 1,
            'featured' => rand(0, 1),
        ];
    }
}
