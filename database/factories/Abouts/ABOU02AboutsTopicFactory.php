<?php

namespace Database\Factories\Abouts;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Abouts\ABOU02AboutsTopic;

class ABOU02AboutsTopicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ABOU02AboutsTopic::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // return [
        //     'title' => $this->faker->text(10),
        //     'subtitle' => $this->faker->text(12),
        //     'description' => $this->faker->text(100),
        //     'text' => $this->faker->text(900),
        //     'path_image' => 'uploads/tmp/image-box.jpg',
        //     'about_id' => 1,
        //     'active' => 1,
        //     'featured' => 1,
        // ];
    }
}
