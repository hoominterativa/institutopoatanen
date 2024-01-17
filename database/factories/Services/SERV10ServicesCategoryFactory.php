<?php

namespace Database\Factories\Services;

use Illuminate\Support\Str;
use App\Models\Services\SERV10ServicesCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class SERV10ServicesCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV10ServicesCategory::class;

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
            'active' => 1,
        ];
    }
}
