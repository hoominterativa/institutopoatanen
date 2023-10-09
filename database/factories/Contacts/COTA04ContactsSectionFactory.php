<?php

namespace Database\Factories\Contacts;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contacts\COTA04ContactsSection;

class COTA04ContactsSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = COTA04ContactsSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'contact_id' => 1,
            'title' => $this->faker->text(10),
            'description' => $this->faker->text(350),
            'active' => 1,
        ];
    }
}
