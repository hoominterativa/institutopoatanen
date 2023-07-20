<?php

namespace Database\Factories\Abouts;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Abouts\ABOU04AboutsSectionGallery;

class ABOU04AboutsSectionGalleryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ABOU04AboutsSectionGallery::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'title_button' => $this->faker->text(10),
            'description' => $this->faker->text(100),
            'link_button' => 'www.example.com',
            'target_link_button' => '_blank',
            'active' => 1,
        ];
    }
}
