<?php

namespace Database\Factories\Portfolios;

use Illuminate\Support\Str;
use App\Models\Portfolios\PORT02Portfolios;
use Illuminate\Database\Eloquent\Factories\Factory;

class PORT02PortfoliosFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PORT02Portfolios::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(9);
        return [
            'title' => $title,
            'subtitle' => $this->faker->text(9),
            'text' => $this->faker->text(500),
            'slug' => Str::slug($title),
            'title_button' => $this->faker->text(8),
            'link_button' => 'www.example.com',
            'target_link_button' => '_blank',
            'path_image_icon' => 'uploads/tmp/favicon.png',
            'path_image_box' => 'uploads/tmp/image-box.jpg',
            'path_image_desktop' => 'uploads/tmp/image-box.jpg',
            'path_image_mobile' => 'uploads/tmp/image-box-white.jpg',
            'active' => 1,
            'featured' => 1,
        ];
    }
}
