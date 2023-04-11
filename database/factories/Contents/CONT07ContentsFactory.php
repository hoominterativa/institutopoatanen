<?php

namespace Database\Factories\Contents;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contents\CONT07Contents;

class CONT07ContentsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CONT07Contents::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'link_video' => 'https://www.youtube.com/embed/YlUKcNNmywk&list=RDMM7QU1nvuxaMA&index=21',
            'path_image' => 'uploads/tmp/image-box-white.jpg',
            'active' => 1
        ];
    }
}
