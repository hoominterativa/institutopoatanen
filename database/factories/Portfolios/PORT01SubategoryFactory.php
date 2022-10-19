<?php

namespace Database\Factories\Portfolios;

use App\Models\Portfolios\PORT01PortfoliosSubategory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PORT01SubategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PORT01PortfoliosSubategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(10);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->text(190),
            'featured' => 1,
            'active' => 1,
        ];
    }
}
