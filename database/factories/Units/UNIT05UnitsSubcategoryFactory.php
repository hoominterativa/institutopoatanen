<?php

namespace Database\Factories\Units;

use Illuminate\Support\Str;
use App\Models\Units\UNIT05UnitsSubcategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class UNIT05UnitsSubcategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UNIT05UnitsSubcategory::class;

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
            'active' => 1,
        ];
    }
}
