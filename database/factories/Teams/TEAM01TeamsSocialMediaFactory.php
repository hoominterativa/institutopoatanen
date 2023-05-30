<?php

namespace Database\Factories\Teams;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Teams\TEAM01TeamsSocialMedia;

class TEAM01TeamsSocialMediaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TEAM01TeamsSocialMedia::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'team_id' => rand(1, 12),
            'link' => $this->faker->url(),
            "target_link" => "_blank",
            "path_image_icon" => 'uploads/tmp/favicon.png',
            'active' => 1,
        ];
    }
}
