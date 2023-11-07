<?php

namespace Database\Factories\Services;

use Illuminate\Support\Str;
use App\Models\Services\SERV09ServicesCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class SERV09ServicesCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV09ServicesCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(10);
        return [
            'slug' => Str::slug($title),
            'title' => $title,
            'path_image' => 'uploads/tmp/favicon.png',
            'active' => 1,
            'featured' => rand(0,1)
        ];
    }
}
