<?php

namespace Database\Factories\Products;

use Illuminate\Support\Str;
use App\Models\Products\PROD05ProductsCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class PROD05ProductsCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PROD05ProductsCategory::class;

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
            "slug" => Str::slug($title),
            'active' => 1,
        ];
    }
}
