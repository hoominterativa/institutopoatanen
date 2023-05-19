<?php

namespace Database\Factories\Portals;

use Illuminate\Support\Str;
use App\Models\Portals\POTA01PortalsCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class POTA01PortalsCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = POTA01PortalsCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(16);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'active' => 1,
            'featured_home' => rand(0,1),
        ];
    }
}
