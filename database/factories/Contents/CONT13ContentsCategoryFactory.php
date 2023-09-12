<?php

namespace Database\Factories\Contents;

use Illuminate\Support\Str;
use App\Models\Contents\CONT13ContentsCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class CONT13ContentsCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CONT13ContentsCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {   $title = $this->faker->text(10);
        return [
            'slug' => Str::slug($title),
            'title' => $title,
            'path_image' => 'uploads/tmp/favicon.png',
            'active' => 1,
        ];
    }
}
