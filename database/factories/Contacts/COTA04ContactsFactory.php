<?php

namespace Database\Factories\Contacts;

use Illuminate\Support\Str;
use App\Models\Contacts\COTA04Contacts;
use Illuminate\Database\Eloquent\Factories\Factory;

class COTA04ContactsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = COTA04Contacts::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $titleBanner = $this->faker->text(10);
        return [
            'slug' => Str::slug($titleBanner),
            'active' => 1,
            'title_banner' => $titleBanner,
            'subtitle_banner' => $this->faker->text(10),
            'path_image_banner_desktop' => 'uploads/tmp/gall01_image2.png',
            'path_image_banner_mobile' => 'uploads/tmp/port01_path_image_box.png',
            'background_color_banner' => '#FFFFFF',
            'title_content' => $this->faker->text(10),
            'subtitle_content' => $this->faker->text(10),
            'description_content' => $this->faker->text(100),
            'path_image_content' => 'uploads/tmp/gall01_image1.png',
            'title_button_form' => 'Enviar',
            "email_form" => $this->faker->email(),
            'title_compliance' => $this->faker->text(15),
            'subtitle_compliance' => $this->faker->text(10),
        ];
    }
}
