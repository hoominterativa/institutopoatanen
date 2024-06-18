<?php

namespace Database\Factories\Portfolios;

use Illuminate\Support\Str;
use App\Models\Portfolios\PORT05Portfolios;
use Illuminate\Database\Eloquent\Factories\Factory;

class PORT05PortfoliosFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PORT05Portfolios::class;

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
            'description' => $this->faker->paragraphs(3, true),
            'path_image' => 'uploads/tmp/bg-boxitem.png',
            'active' => 1,
            'featured' => rand(0, 1),
            //Banner show
            'title_banner' => $title,
            'path_image_desktop_banner' => 'uploads/tmp/image-box.jpg',
            'path_image_mobile_banner' => 'uploads/tmp/port01_path_image_box.png',
            'active_banner' => 1
        ];
    }
}
