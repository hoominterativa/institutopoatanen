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
            'compliance_id' => 1,
            'title' => $this->faker->text(10),
            'subtitle' => $this->faker->text(10),
            'text' => $this->faker->paragraphs(3),
            'path_image_icon' => 'uploads/tep/favicon.png',
            'active' => 1,
        ];
    }
}
