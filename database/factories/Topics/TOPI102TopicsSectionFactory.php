<?php

namespace Database\Factories\Topics;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Topics\TOPI102TopicsSection;

class TOPI102TopicsSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TOPI102TopicsSection::class;

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
            'path_image_desktop' => 'uploads/temp/image_temporary.png',
            'path_image_mobile' => 'uploads/temp/image_temporary.png',
            'active' => 1
        ];
    }
}
