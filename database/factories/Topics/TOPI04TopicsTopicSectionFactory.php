<?php

namespace Database\Factories\Topics;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Topics\TOPI04TopicsTopicSection;

class TOPI04TopicsTopicSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TOPI04TopicsTopicSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'topic_id' => 1,
            'title' => $this->faker->text(10),
            'path_image_icon' => 'uploads/tmp/favicon.png',
            'path_image_box' => 'uploads/tmp/image-box.jpg',
            'active' => 1,
        ];
    }
}
