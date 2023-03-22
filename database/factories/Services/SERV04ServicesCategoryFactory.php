<?php

namespace Database\Factories\Services;

use Illuminate\Support\Str;
use App\Models\Services\SERV04ServicesCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class SERV04ServicesCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV04ServicesCategory::class;

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
            'description' => $this->faker->text(400),
            'path_image' => 'uploads/tmp/image-pmg.png',
            'active' => 1,
        ];
    }
}
