<?php

namespace Database\Factories\Portfolios;

use Illuminate\Support\Str;
use App\Models\Portfolios\PORT03Portfolios;
use Illuminate\Database\Eloquent\Factories\Factory;

class PORT03PortfoliosFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PORT03Portfolios::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(9);
        return [
            'category_id' => rand(1,4),
            'slug' => Str::slug($title),
            'title' => $title,
            'description' => $this->faker->text(50),
            'text' => $this->faker->text(500),
            'title_button' => $this->faker->text(8),
            'link_button' => $this->faker->url(),
            'target_link_button' => '_blank',
            'path_image_before' => 'uploads/tmp/bg-boxitem.png',
            'path_image_after' => 'uploads/tmp/thumbnail.png',
            'active' => 1,
            'featured' => rand(0,1),
        ];
    }
}
