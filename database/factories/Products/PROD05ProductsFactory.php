<?php

namespace Database\Factories\Products;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Products\PROD05Products;

class PROD05ProductsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PROD05Products::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(12);
        $subtitle = $this->faker->text(9);

        return [
            "category_id" =>rand(1, 5),
            "subcategory_id" =>rand(1, 5),
            "slug" => Str::slug($title.' '.$subtitle),
            'title' => $this->faker->text(10),
            'active' => 1,
        ];
    }
}
