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
        $title = $this->faker->text(15);
        return [
            "title_page" => $title,
            "slug" => Str::slug($title),
            "title_banner" => $this->faker->text(15),
            "path_image_banner" => 'uploads/tmp/bg-banner-inner.jpg',
        ];
    }
}
