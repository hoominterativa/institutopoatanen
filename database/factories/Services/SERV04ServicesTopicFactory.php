<?php

namespace Database\Factories\Services;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Services\SERV04ServicesTopic;

class SERV04ServicesTopicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV04ServicesTopic::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'service_id' => rand(1,4),
            'title' => $this->faker->text(10),
            'slug' => $this->faker->text(10),
            'text' => $this->faker->text(700),
            'active' => 1,
        ];
    }
}
