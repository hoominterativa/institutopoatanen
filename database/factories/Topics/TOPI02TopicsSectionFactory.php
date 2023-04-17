<?php

namespace Database\Factories\Topics;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Topics\TOPI02TopicsSection;

class TOPI02TopicsSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TOPI02TopicsSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "title" => $this->faker->text(10),
            "subtitle" => $this->faker->text(10),
            "description" => $this->faker->text(100),
            "path_image_background" => 'uploads/temp/bg-section-gray.jpg',
            "active" => 1,
        ];
    }
}
