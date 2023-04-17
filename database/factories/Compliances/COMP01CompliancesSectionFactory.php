<?php

namespace Database\Factories\Compliances;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Compliances\COMP01CompliancesSection;

class COMP01CompliancesSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = COMP01CompliancesSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 'title' => $this->faker->text(10),
            // 'path_image' => 'uploads/temp/image_temporary.png',
            'active' => 1,
        ];
    }
}
