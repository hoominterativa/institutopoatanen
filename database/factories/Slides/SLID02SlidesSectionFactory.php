<?php

namespace Database\Factories\Slides;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Slides\SLID02SlidesSection;

class SLID02SlidesSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SLID02SlidesSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'path_image_background' => 'uploads/temp/image_temporary.png',
            'colors' => '#6f3bed,#5cffc4,#5a5d7e,#7d00bc',
            'active' => 1,
        ];
    }
}
