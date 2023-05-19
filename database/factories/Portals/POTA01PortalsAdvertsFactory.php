<?php

namespace Database\Factories\Portals;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Portals\POTA01PortalsAdverts;

class POTA01PortalsAdvertsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = POTA01PortalsAdverts::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            /*'title' => $this->faker->text(10),
            'path_image' => 'uploads/temp/image_temporary.png',
            'active' => 1,*/
        ];
    }
}
