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
            /*'title' => $this->faker->text(10),
            'path_image' => 'uploads/temp/image_temporary.png',
            'active' => 1,*/
        ];
    }
}
