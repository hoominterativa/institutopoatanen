<?php

namespace Database\Factories\Contacts;

use Illuminate\Support\Str;
use App\Models\Contacts\COTA04ContactsCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class COTA04ContactsCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = COTA04ContactsCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(10);
        return [
            'slug' => Str::slug($title),
            'title' => $title,
            'path_image' => 'uploads/tmp/favicon.png',
            'active' => 1,
        ];
    }
}
