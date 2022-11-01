<?php

namespace Database\Factories\Services;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Services\SERV01ServicesPortfolioGallery;

class SERV01ServicesPortfolioGalleryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV01ServicesPortfolioGallery::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'path_image' => 'uploads/temp/image-box.jpg',
            'portfolio_id' => rand(1,5),
        ];
    }
}
