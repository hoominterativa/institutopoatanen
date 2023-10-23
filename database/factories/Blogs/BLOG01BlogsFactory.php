<?php

namespace Database\Factories\Blogs;

use App\Models\Blogs\BLOG01Blogs;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class BLOG01BlogsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BLOG01Blogs::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(25);
        return [
            'category_id' => rand(1,4),
            'title' => $title,
            'slug' => Str::slug($title),
            'path_image_thumbnail' => 'uploads/tmp/inner-image.jpg',
            'path_image_icon' => 'uploads/tmp/favicon.png',
            'path_image' => 'uploads/tmp/image-box.jpg',
            'publishing' => date('Y-m-d'),
            'description' => $this->faker->text(60),
            'text' => $this->faker->paragraph(3),
            'featured_home' => rand(0,1),
            'featured_page' => rand(0,1),
            'active' => 1,
        ];
    }
}
