<?php

namespace Database\Factories\Blogs;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Blogs\BLOG01BlogsSection;

class BLOG01BlogsSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BLOG01BlogsSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 'title' => $this->faker->text(10),
            // 'path_image' => 'uploads/temp/image_temporary.png',
            'active' => 1,
        ];
    }
}
