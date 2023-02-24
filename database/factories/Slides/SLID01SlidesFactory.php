<?php

namespace Database\Factories\Slides;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Slides\SLID01Slides;

class SLID01SlidesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SLID01Slides::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => 'TITULO BANNER',
            'subtitle' => 'SUBTITULO',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non liberolor sit amet, consectetur adipiscing elit. Cras vel tortor',
            'title_button' => 'CTA',
            'link_button' => 'https://www.lipsum.com/',
            'path_image_desktop' => 'uploads/tmp/bg-slide.jpg',
            'path_image_png' => 'uploads/tmp/png-slide.png',
            'active' => 1,

            'title_mobile' => 'Título Mobile',
            'subtitle_mobile' => 'Subtítulo Mobile',
            'description_mobile' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'title_button_mobile' => 'CTA Mobile',
            'path_image_mobile' => 'uploads/tmp/bg-slid-mobile.jpg',
            'link_button_mobile' => 'https://www.lipsum.com/',
            'active_mobile' => 1
        ];
    }
}
