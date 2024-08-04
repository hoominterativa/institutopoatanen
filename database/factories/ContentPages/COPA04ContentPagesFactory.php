<?php

namespace Database\Factories\ContentPages;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ContentPages\COPA04ContentPages;

class COPA04ContentPagesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = COPA04ContentPages::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title_page' => $this->faker->text(10),
            'active' => 1,
        ];
    }
}
