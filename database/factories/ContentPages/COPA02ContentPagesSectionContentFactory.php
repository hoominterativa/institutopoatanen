<?php

namespace Database\Factories\ContentPages;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ContentPages\COPA02ContentPagesSectionContent;

class COPA02ContentPagesSectionContentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = COPA02ContentPagesSectionContent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'subtitle' => $this->faker->text(10),
            'path_image_desktop' => 'uploads/tmp/image-box.jpg',
            'path_image_mobile' => 'uploads/tmp/image-box.jpg',
            'background_color' => '#EFEFEF',
            'active' => 1,
        ];
    }
}
