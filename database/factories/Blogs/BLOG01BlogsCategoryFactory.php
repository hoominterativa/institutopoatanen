<?php

namespace Database\Factories\Blogs;

use Illuminate\Support\Str;
use App\Models\Blogs\BLOG01BlogsCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class BLOG01BlogsCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BLOG01BlogsCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(16);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'active' => 1,
        ];
    }
}
