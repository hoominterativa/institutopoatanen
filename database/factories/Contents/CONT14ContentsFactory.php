<?php

namespace Database\Factories\Contents;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contents\CONT14Contents;

class CONT14ContentsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CONT14Contents::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => rand(1,3),
            'title' => $this->faker->text(10),
            'subtitle' => $this->faker->text(8),
            'description' => $this->faker->text(500),
            'link' => 'https://www.youtube.com/embed/dHFN1WGPzvk?si=P57I72jlvjOvxOpM',
            'path_image' => 'uploads/tmp/thumbnail.png',
            'active' => 1,
        ];
    }
}
