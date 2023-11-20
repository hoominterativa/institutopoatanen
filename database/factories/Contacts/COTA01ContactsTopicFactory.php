<?php

namespace Database\Factories\Contacts;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contacts\COTA01ContactsTopic;

class COTA01ContactsTopicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = COTA01ContactsTopic::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 'title' => $this->faker->text(10),
            // 'path_image' => 'uploads/temp/image_temporary.png',
            // 'active' => 1,
        ];
    }
}
