<?php

namespace Database\Factories\Contacts;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contacts\COTA01Contacts;

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
        return [
            'title' => $this->faker->text(10),
            'path_image' => 'uploads/temp/image_temporary.png',
            'active' => 1,
        ];
    }
}
