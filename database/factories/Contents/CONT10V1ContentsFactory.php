<?php

namespace Database\Factories\Contents;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contents\CONT10V1Contents;

class CONT10V1ContentsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CONT10V1Contents::class;

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
            'date' => $this->faker->date('Y-m-d'),
            'title' => $this->faker->text(10),
            'description' => $this->faker->text(30),
            'locale' => $this->faker->randomElement($event_locale),
            'link' => $this->faker->url(),
            'link_target' => $this->faker->randomElement(['_self', '_blank']),
            'active' => 1
        ];
    }
}
