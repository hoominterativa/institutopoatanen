<?php

namespace Database\Factories\Schedules;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Schedules\SCHE02Schedules;

class SCHE02SchedulesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SCHE02Schedules::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $event_locale = [
            'Salvador-BA',
            'São Paulo-SP',
            'Rio de Janeiro-RJ',
            'Recife-PE',
            'Aracaju-SE',
            'Brasília-DF',
            'Fortaleza-CE',
            'Belo Horizonte-MG',
            'Curitiba-PR',
            'Porto Alegre-RS',
            'Belém-PA',
            'Manaus-AM',
            'Natal-RN',
            'Vitória-ES',
            'Cuiabá-MT',
            'Goiânia-GO',
        ];

        return [
            'event_locale' => $this->faker->randomElement($event_locale),
            'event_date' => $this->faker->date('Y-m-d'),
            'informations' => $this->faker->text(350),
            'event_title' => $this->faker->text(15),
            'title_button_one' => $this->faker->text(10),
            'link_button_one' => $this->faker->url(),
            'target_link_button_one' => $this->faker->randomElement(['_self', '_blank']),
            'title_button_two' => $this->faker->text(10),
            'link_button_two' => $this->faker->url(),
            'active' => 1,
            'featured' => 1,
        ];
    }
}
