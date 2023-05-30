<?php

namespace Database\Factories\Teams;

use Illuminate\Support\Str;
use App\Models\Teams\TEAM01TeamsCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $title = $this->faker->text(12);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'path_image_icon' => 'uploads/tmp/favicon.png',
            'active' => 1,
        ];
    }
}
