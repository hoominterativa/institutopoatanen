<?php

namespace Database\Factories\Products;

use Illuminate\Support\Str;
use App\Models\Products\PROD02ProductsCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class PROD02ProductsCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PROD02ProductsCategory::class;

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
            'featured' => rand(0, 1)
        ];
    }
}
