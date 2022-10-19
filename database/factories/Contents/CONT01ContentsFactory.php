<?php

namespace Database\Factories\Contents;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contents\CONT01Contents;

class CONT01ContentsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CONT01Contents::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => 'Título',
            'subtitle' => 'Subtítulo',
            'link' => 'https://www.lipsum.com/',
            'path_image' => 'uploads/tmp/cont01_path_image.png',
        ];
    }
}
