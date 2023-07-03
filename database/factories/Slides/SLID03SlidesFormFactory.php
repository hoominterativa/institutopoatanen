<?php

namespace Database\Factories\Slides;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Slides\SLID03SlidesForm;

class SLID03SlidesFormFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SLID03SlidesForm::class;

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
