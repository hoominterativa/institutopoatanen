<?php

namespace Database\Factories\Contents;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contents\CONT09ContentsTopic;

class CONT09ContentsTopicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CONT09ContentsTopic::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 'link' => 'https://www.lipsum.com/',
            // 'link_target' => '_blank',
            // 'path_image_icon' => 'uploads/tmp/favicon.png',
            // 'active' => 1,
        ];
    }
}
