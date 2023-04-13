<?php

namespace Database\Factories\ContentPages;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ContentPages\COPA02ContentPagesTopic;

class COPA02ContentPagesTopicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = COPA02ContentPagesTopic::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'subtitle' => $this->faker->text(12),
            'description' => $this->faker->text(200),
            'path_image_box' => 'uploads/tmp/gall01_image2.png',
            'active' => 1,
        ];
    }
}
