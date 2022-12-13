<?php

namespace Database\Factories\WorkWith;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\WorkWith\WOWI01WorkWithSection;

class WOWI01WorkWithSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WOWI01WorkWithSection::class;

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
