<?php

namespace Database\Factories\Contacts;

use Illuminate\Support\Str;
use App\Models\Contacts\COTA01Contacts;
use Illuminate\Database\Eloquent\Factories\Factory;

class COTA01ContactsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = COTA01Contacts::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $titlePage = $this->faker->text(10);
        return [
            'title_page' => $titlePage,
            'slug' => Str::slug($titlePage),
            'title_banner' => $this->faker->text(15),
            'description_banner' => $this->faker->text(350),
            'path_image_desktop_banner' => 'uploads/tmp/bg-banner-inner.jpg',
            'path_image_mobile_banner' => 'uploads/tmp/port01_path_image_box.png',
            'background_color' => '#FFFFFF',
            'title_section' => $this->faker->text(15),
            'description_section' => $this->faker->text(350),
            'title_form' => $this->faker->text(15),
            'description_form' => $this->faker->text(200),
            'title_button_form' => 'Enviar',
            'path_image_section_topic' => 'uploads/tmp/image-pmg.png',
            "inputs_form" => '{"column_nome_text":{"placeholder":"Nome","option":"","type":"text"},"column_e-mail_email":{"placeholder":"E-mail","option":"","type":"email"},"column_celular_cellphone":{"placeholder":"Celular","option":"","type":"cellphone"},"column_assunto_select":{"placeholder":"Assunto","option":"Duvidas, Reclama\u00e7\u00f5es, Or\u00e7amentos","type":"select"},"column_mensagem_textarea":{"placeholder":"Mensagem","option":"","type":"textarea"}}',
            "email_form" => $this->faker->email(),
            'active' => 1,
            'compliance_id' => 1,
        ];
    }
}
