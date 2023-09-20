<?php

namespace Database\Factories\Abouts;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Abouts\ABOU05Abouts;

class ABOU05AboutsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ABOU05Abouts::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            /*'title' => $this->faker->text(10),
            'path_image' => 'uploads/temp/image_temporary.png',
            'active' => 1,*/
        ];
    }
}
