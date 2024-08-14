<?php

namespace Database\Factories\Services;

use Illuminate\Support\Str;
use App\Models\Services\SERV11ServicesSession;
use Illuminate\Database\Eloquent\Factories\Factory;

class SERV11ServicesSessionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV11ServicesSession::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(10);
        $subtitle = $this->faker->text(10);

        return [
            'slug' => Str::slug($title. ' '.$subtitle),
            'title' => $title,
            'subtitle' => $subtitle,
            'active' => 1,
        ];
    }
}
