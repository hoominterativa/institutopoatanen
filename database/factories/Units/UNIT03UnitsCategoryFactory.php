<?php

namespace Database\Factories\Units;

use Illuminate\Support\Str;
use App\Models\Units\UNIT03UnitsCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class UNIT03UnitsCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UNIT03UnitsCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(12);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'path_image_icon' => 'uploads/tmp/favicon.png',
            'active' => 1,
        ];
    }
}
