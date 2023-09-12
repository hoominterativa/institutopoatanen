<?php

namespace Database\Factories\Contents;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contents\CONT13Contents;

class CONT13ContentsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CONT13Contents::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => rand(1, 7),
            'title' => $this->faker->text(10),
            'subtitle' => $this->faker->text(12),
            'description' => $this->faker->text(120),
            'title_price' => $this->faker->text(10),
            'price' => $this->faker->randomFloat(2, 0, 100),
            'title_button' => $this->faker->text(10),
            'link_button' => $this->faker->url(),
            'target_link' => '_blank',
            'title_featured' => $this->faker->text(10),
            'color_featured' => $this->faker->randomElement(['#6f3bed', '#e5e502', '#11e502']),
            'path_image' => $this->faker->randomElement(['uploads/tmp/image-box.jpg', 'uploads/tmp/gall01_image1.png', 'uploads/tmp/thumbnail.png']),
            'active' => 1,
            'featured' => rand(0, 1)
        ];
    }
}
