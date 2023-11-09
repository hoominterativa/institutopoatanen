<?php

namespace Database\Factories\Abouts;

use Illuminate\Support\Str;
use App\Models\Abouts\ABOU04Abouts;
use Illuminate\Database\Eloquent\Factories\Factory;

class ABOU04AboutsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ABOU04Abouts::class;

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
            'subtitle' => $this->faker->text(10),
            'text' => $this->faker->text(999),
            'path_image' => 'uploads/tmp/image-pmg.png',
            'active' => 1,
        ];
    }
}
