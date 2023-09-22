<?php

namespace Database\Factories\Contacts;

use Illuminate\Support\Str;
use App\Models\Contacts\COTA03Contacts;
use Illuminate\Database\Eloquent\Factories\Factory;

class COTA03ContactsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = COTA03Contacts::class;

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

            'title_content' => $this->faker->text(10),
            'subtitle_content' => $this->faker->text(10),
            'title_button_content' => $this->faker->text(10),
            'link_button_content' => $this->faker->url(),
            'target_link_button_content' => '_blank',
            'description_content' => $this->faker->text(100),
            'path_image_content' => 'uploads/tmp/gall01_image1.png',

            'title_form' => $this->faker->text(15),
            'description_form' => $this->faker->text(100),

            'title_button_form' => 'Enviar',

            "inputs_form" => '{"column_nome_text":{"placeholder":"Nome","option":"","type":"text"},"column_e-mail_email":{"placeholder":"E-mail","option":"","type":"email"},"column_celular_cellphone":{"placeholder":"Celular","option":"","type":"cellphone"},"column_assunto_select":{"placeholder":"Assunto","option":"Duvidas, Reclama\u00e7\u00f5es, Or\u00e7amentos","type":"select"},"column_mensagem_textarea":{"placeholder":"Mensagem","option":"","type":"textarea"}}',
            "email_form" => $this->faker->email(),

            'active' => 1,
        ];
    }
}
