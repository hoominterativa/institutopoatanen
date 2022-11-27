<?php

namespace Database\Factories\Contacts;

use Illuminate\Support\Str;
use App\Models\Contacts\COTA01Contacts;
use Illuminate\Database\Eloquent\Factories\Factory;

class COTA01ContactsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = COTA01Contacts::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $titlePage = $this->faker->text(10);
        return [
            'title_page' => $titlePage,
            'slug' => Str::slug($titlePage),
            'title_banner' => $this->faker->text(15),
            'description_banner' => $this->faker->text(350),
            'path_image_banner' => 'uploads/tmp/bg-banner-inner.jpg',
            'title_section' => $this->faker->text(15),
            'description_section' => $this->faker->text(350),
            'title_form' => $this->faker->text(15),
            'description_form' => $this->faker->text(200),
            'title_button_form' => 'Enviar',
            'path_image_section_topic' => 'uploads/tmp/image-pmg.png',
            'inputs_form' => '{}',
            'active' => 1,
        ];
    }
}
