<?php

namespace Database\Factories\BlankPages;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\BlankPages\BAPA01BlankPages;

class BAPA01BlankPagesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BAPA01BlankPages::class;

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
