<?php

namespace Database\Factories\Portals;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Portals\POTA01PortalsSection;

class POTA01PortalsSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = POTA01PortalsSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'active' => 1,
        ];
    }
}
