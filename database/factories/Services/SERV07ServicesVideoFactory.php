<?php

namespace Database\Factories\Services;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Services\SERV07ServicesVideo;

class SERV07ServicesVideoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV07ServicesVideo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => rand(1,4),
            'path_image' => 'uploads/tmp/guerreiro.png',
            'active' => 1,
            'link' => 'https://www.youtube.com/embed/Lj8iD2XMFaA'
        ];
    }
}
