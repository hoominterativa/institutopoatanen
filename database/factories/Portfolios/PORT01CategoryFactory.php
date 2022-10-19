<?php

namespace Database\Factories\Portfolios;

use App\Models\Portfolios\PORT01PortfoliosCategory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PORT01CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PORT01PortfoliosCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(10);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'path_image_icon' => 'uploads/tmp/port01_path_image_icon_category.png',
            'view_menu' => 1,
            'featured' => 1,
            'active' => 1,
        ];
    }
}
