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
            'title' => 'Título Banner',
            'subtitle' => 'Subtítulo Banner',
            'description' => 'Donec diam enim, rhoncus sed gravida et',
            'title_button' => 'Call to Action',
            'link_button' => 'https://www.lipsum.com/',
            'active' => 1,
        ];
    }
}
