<?php

namespace Database\Factories\Blogs;

use Illuminate\Support\Str;
use App\Models\Blogs\BLOG03Blogs;
use Illuminate\Database\Eloquent\Factories\Factory;

class BLOG03BlogsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BLOG03Blogs::class;

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
            'path_image' => 'uploads/tmp/image-box.jpg',
            'path_image_box' => 'uploads/tmp/slid01_path_image_desktop.png',
            'publishing' => date('Y-m-d'),
            'description' => $this->faker->text(60),
            'text' => $this->faker->paragraph(3),
            'featured' => rand(0,1),
            'active' => 1,
        ];
    }
}
