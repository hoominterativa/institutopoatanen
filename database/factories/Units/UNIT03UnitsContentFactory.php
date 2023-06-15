<?php

namespace Database\Factories\Units;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Units\UNIT03UnitsContent;

class UNIT03UnitsContentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UNIT03UnitsContent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'unit_id' => rand(1,8),
            'title' => $this->faker->text(10),
            'subtitle' => $this->faker->text(10),
            'text' => $this->faker->text(10),
            'title_button' => $this->faker->text(12),
            'link_button' => $this->faker->url(),
            'target_link_button' => '_blank',
            'path_image_desktop' => 'uploads/tmp/secaobox.png',
            'path_image_mobile' => 'uploads/tmp/port01_path_image_box.png',
            'path_image' => 'uploads/tmp/gall01_image2.png',
            'background_color' => '#CCCCCC',
            'active' => 1,
        ];
    }
}
