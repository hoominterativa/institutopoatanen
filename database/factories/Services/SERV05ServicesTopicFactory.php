<?php

namespace Database\Factories\Services;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Services\SERV05ServicesTopic;

class SERV05ServicesTopicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV05ServicesTopic::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'service_id' => rand(1,12),
            'title' => $this->faker->text(10),
            'subtitle' => $this->faker->text(10),
            'description' => $this->faker->text(150),
            'path_image' => 'uploads/tmp/thumbnail.png',
            'path_image' => 'uploads/tmp/favicon.png',
            'active' => 1,
        ];
    }
}
