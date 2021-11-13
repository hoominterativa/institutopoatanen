<?php

namespace Database\Factories;

use App\Models\Topics\TOPI01Topics;
use Illuminate\Database\Eloquent\Factories\Factory;


class TOPI01TopicsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TOPI01Topics::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => 'Titulo Topico',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'path_image' => 'uploads/tmp/topic_icon.jpg',
            'active' => 1,
        ];
    }
}
