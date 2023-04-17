<?php

namespace Database\Factories\Contacts;

use Illuminate\Support\Str;
use App\Models\Contacts\COTA02Contacts;
use Illuminate\Database\Eloquent\Factories\Factory;

class COTA02ContactsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = COTA02Contacts::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $titleBanner = $this->faker->text(10);
        return [
            'title_banner' => $titleBanner,
            'slug' => Str::slug($titleBanner),
            'subtitle_banner' => $this->faker->text(10),
            'path_image_banner_desktop' => 'uploads/tmp/gall01_image2.png',
            'path_image_banner_mobile' => 'uploads/tmp/port01_path_image_box.png',
            'background_color_banner' => '#FFFFFF',

            'path_image_topic_desktop' => 'uploads/tmp/gall01_image1.png',
            'path_image_topic_mobile' => 'uploads/tmp/port01_path_image_left.jpg',
            'background_color_topic' => '#FFFFFF',

            'title_form' => $this->faker->text(15),
            'description_form' => $this->faker->text(100),
            'path_image_form_desktop' => 'uploads/tmp/gall01_image2.png',
            'path_image_form_mobile' => 'uploads/tmp/port01_path_image_box.png',
            'background_color_form' => '#FFFFFF',

            'title_button_form' => 'Enviar',

            "inputs_form" => '{"column_nome_text":{"placeholder":"Nome","option":"","type":"text"},"column_e-mail_email":{"placeholder":"E-mail","option":"","type":"email"},"column_celular_cellphone":{"placeholder":"Celular","option":"","type":"cellphone"},"column_assunto_select":{"placeholder":"Assunto","option":"Duvidas, Reclama\u00e7\u00f5es, Or\u00e7amentos","type":"select"},"column_mensagem_textarea":{"placeholder":"Mensagem","option":"","type":"textarea"}}',
            "email_form" => $this->faker->email(),

            'active' => 1,
        ];
    }
}
