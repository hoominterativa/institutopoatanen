<?php

namespace Database\Factories\Services;

use Illuminate\Support\Str;
use App\Models\Services\SERV12ServicesCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class SERV12ServicesCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV12ServicesCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(12);
        return [
            'slug' => Str::slug($title),
            'title' => $title,
            'text' => $this->faker->paragraphs(2, true),
            'path_image' => 'uploads/tmp/png-slide.png',
            'active' => 1,
            'featured' => rand(0,1)
        ];
    }
}
