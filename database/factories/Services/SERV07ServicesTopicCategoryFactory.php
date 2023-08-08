<?php

namespace Database\Factories\Services;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Services\SERV07ServicesTopicCategory;

class SERV07ServicesTopicCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV07ServicesTopicCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => rand(1,4),
            'title' => $this->faker->text(10),
            'description' => $this->faker->text(100),
            'path_image' => 'uploads/tmp/thumbnail.png',
            'path_image_icon' => 'uploads/tmp/favicon.png',
            'active' => 1,
        ];
    }
}
