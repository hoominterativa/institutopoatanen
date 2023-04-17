<?php

namespace Database\Factories\ContentPages;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ContentPages\COPA01ContentPagesSection;

class COPA01ContentPagesSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = COPA01ContentPagesSection::class;

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
