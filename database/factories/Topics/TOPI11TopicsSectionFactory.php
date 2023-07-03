<?php

namespace Database\Factories\Topics;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Topics\TOPI11TopicsSection;

class TOPI11TopicsSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TOPI11TopicsSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'subtitle' => $this->faker->text(13),
            'description' => $this->faker->text(200),
            'path_image' => 'uploads/tmp/image-pmg.png',
            'active' => 1,
        ];
    }
}
