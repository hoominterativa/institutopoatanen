<?php

namespace Database\Factories\Services;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Services\SERV11ServicesSection;

class SERV11ServicesSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV11ServicesSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //Section
            'title_section' => $this->faker->text(10),
            'subtitle_section' => $this->faker->text(10),
            'description_section' => $this->faker->text(250),
            'active_section' => 1,
            //Banner
            'title_banner' => $this->faker->text(10),
            'subtitle_banner' => $this->faker->text(10),
            'description_banner' => $this->faker->text(250),
            'active_banner' => 1,
        ];
    }
}
