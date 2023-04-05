<?php

namespace Database\Factories\Frequently;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Frequently\FREQ01Frequently;

class FREQ01FrequentlyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FREQ01Frequently::class;

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
