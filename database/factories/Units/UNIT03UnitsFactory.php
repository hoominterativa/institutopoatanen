<?php

namespace Database\Factories\Units;

use Illuminate\Support\Str;
use App\Models\Units\UNIT03Units;
use Illuminate\Database\Eloquent\Factories\Factory;

class UNIT03UnitsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UNIT03Units::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(10);
        return [
            'category_id' => rand(1,6),
            'title' => $title,
            'slug' => Str::slug($title),
            'path_image' => 'uploads/tmp/image-box.jpg',
            'path_image_icon' => 'uploads/tmp/favicon.png',
            'active' => 1,

            // Table show
            'title_show' => $this->faker->text(10),
            'subtitle_show' => $this->faker->text(10),
            'path_image_icon_show' => 'uploads/tmp/favicon.png',
        ];
    }
}
