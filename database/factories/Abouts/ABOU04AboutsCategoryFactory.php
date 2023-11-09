<?php

namespace Database\Factories\Abouts;

use Illuminate\Support\Str;
use App\Models\Abouts\ABOU04AboutsCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ABOU04AboutsCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ABOU04AboutsCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(10);
        return [
            'about_id' => rand(1,2),
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->text(20),
            'active' => 1,
        ];
    }
}
