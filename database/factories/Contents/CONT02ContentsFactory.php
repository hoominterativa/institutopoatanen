<?php

namespace Database\Factories\Contents;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contents\CONT02Contents;

class CONT02ContentsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CONT02Contents::class;

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
