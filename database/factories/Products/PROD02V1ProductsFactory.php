<?php

namespace Database\Factories\Products;

use Illuminate\Support\Str;
use App\Models\Products\PROD02V1Products;
use Illuminate\Database\Eloquent\Factories\Factory;

class PROD02V1ProductsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PROD02V1Products::class;

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
            "title" => $title,
            "subtitle" => $subtitle,
            "slug" => Str::slug($title.' '.$subtitle),
            "description" => $this->faker->text(60),
            "text" => $this->faker->text(700),
            "path_image_box" => "uploads/tmp/image-box.jpg",
            "title_button" => $this->faker->text(10),
            "link_button" => $this->faker->url(),
            "target_link_button" => "_blank",
            "active" => 1,
            "featured" => rand(0, 1)
        ];
    }
}
