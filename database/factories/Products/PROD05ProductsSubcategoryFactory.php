<?php

namespace Database\Factories\Products;

use Illuminate\Support\Str;
use App\Models\Products\PROD05ProductsSubcategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class PROD05ProductsSubcategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PROD05ProductsSubcategory::class;

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
