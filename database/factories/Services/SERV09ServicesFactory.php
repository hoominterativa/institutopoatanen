<?php

namespace Database\Factories\Services;

use Illuminate\Support\Str;
use App\Models\Services\SERV09Services;
use Illuminate\Database\Eloquent\Factories\Factory;

class SERV09ServicesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SERV09Services::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(10);
        return [
            'category_id' => rand(1, 7),
            'slug' => Str::slug($title),
            'title' => $title,
            'subtitle' => $this->faker->text(12),
            'description' => $this->faker->text(120),
            'text' => $this->faker->text(500),
            'link' => $this->faker->url(),
            'title_info' => 'Reserve agora',
            'informations' => 'Total (taxes and charges incl.)',
            'price' => $this->faker->randomFloat(2, 0, 100),
            'path_image' => $this->faker->randomElement(['uploads/tmp/image-box.jpg', 'uploads/tmp/gall01_image1.png', 'uploads/tmp/thumbnail.png']),
            'active' => 1,
            'percentage' => rand(0, 100),
            'featured' => rand(0, 1),
            'address' => $this->faker->address(),
            'map_link' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3888.8152687932293!2d-38.358329925842426!3d-12.91959165876374!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x7163e0787480cb5%3A0x2efae57583eed193!2sHoom%20Interativa!5e0!3m2!1spt-BR!2sbr!4v1712346237764!5m2!1spt-BR!2sbr',
            // Section Banner
            'title_banner' => $this->faker->text(10),
            'subtitle_banner' => $this->faker->text(10),
            'active_banner' => 1,
            'path_image_desktop' => 'uploads/tmp/bg-boxitem.png',
            'path_image_mobile' => 'uploads/tmp/image-box-white.jpg',
            'background_color' => '#FFFFFF',
        ];
    }
}
