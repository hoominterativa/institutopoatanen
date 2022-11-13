<?php

namespace Database\Factories\Topics;

use App\Models\Topics\TOPI02Topics;
use Illuminate\Database\Eloquent\Factories\Factory;

class TOPI02TopicsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TOPI02Topics::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'description' => $this->faker->text(110),
            'link' => 'https://www.lipsum.com/',
            'path_image_icon' => 'uploads/tmp/icon-general.svg',
            'path_image' => 'uploads/tmp/image-box.jpg',
            'active' => 1,
        ];
    }
}
