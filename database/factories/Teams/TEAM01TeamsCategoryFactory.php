<?php

namespace Database\Factories\Teams;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Teams\TEAM01TeamsCategory;

class TEAM01TeamsCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TEAM01TeamsCategory::class;

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
