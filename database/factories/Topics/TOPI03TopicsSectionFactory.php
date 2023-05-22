<?php

namespace Database\Factories\Topics;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Topics\TOPI03TopicsSection;

class TOPI03TopicsSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TOPI03TopicsSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'subtitle' => $this->faker->text(10),
            'description' => $this->faker->text(300),
            'active' => 1,
        ];
    }
}
