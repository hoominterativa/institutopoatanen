<?php

namespace Database\Factories\Abouts;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Abouts\ABOU02AboutsLastSection;

class ABOU02AboutsLastSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ABOU02AboutsLastSection::class;

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
            'description' => $this->faker->text(200),
            'title_button' => $this->faker->text(12),
            'link_button' => $this->faker->url(),
            'target_link_button' => '_blank',
            'path_image' => 'uploads/tmp/image-pmg.png',
            'active' => 1,
        ];
    }
}
