<?php

namespace Database\Factories\ContentPages;

use Illuminate\Support\Str;
use App\Models\ContentPages\COPA01ContentPages;
use Illuminate\Database\Eloquent\Factories\Factory;

class COPA01ContentPagesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = COPA01ContentPages::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "title" => $this->faker->text(10),
            "subtitle" => $this->faker->text(15),
            "text" => $this->faker->paragraph(3),
            "path_image" => 'uploads/tmp/favicon.png',
            "active" => 1
        ];
    }
}
