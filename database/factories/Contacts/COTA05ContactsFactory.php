<?php

namespace Database\Factories\Contacts;

use Illuminate\Support\Str;
use App\Models\Contacts\COTA05Contacts;
use Illuminate\Database\Eloquent\Factories\Factory;

class COTA05ContactsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = COTA05Contacts::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $titlePage = $this->faker->text(10);
        return [
            'slug' => Str::slug($titlePage),
            'title_page' => $titlePage,
            'compliance_id' => 1,
            'active' => 1,

            'title_banner' => $this->faker->text(10),
            'subtitle_banner' => $this->faker->text(10),
            'path_image_desktop_banner' => 'uploads/tmp/thumbnail.png',
            'path_image_mobile_banner' => 'uploads/tmp/retangle.png',
            'background_color_banner' => '#CCCCCC',
            'active_banner' => 1,

            'title_form' => $this->faker->text(10),
            'description_form' => $this->faker->text(400),
            'path_image_icon_form' => 'uploads/tmp/favicon.png',
            'email_form' => $this->faker->email(),
            "inputs_form" => '{"column_nome_text":{"placeholder":"Nome","option":"","type":"text"},"column_e-mail_email":{"placeholder":"E-mail","option":"","type":"email"},"column_celular_cellphone":{"placeholder":"Celular","option":"","type":"cellphone"},"column_assunto_select":{"placeholder":"Assunto","option":"Duvidas, Reclama\u00e7\u00f5es, Or\u00e7amentos","type":"select"},"column_mensagem_textarea":{"placeholder":"Mensagem","option":"","type":"textarea"}}',
            'inputs_assessments' => '{"column_assunto_select":{"placeholder":"Atendimento","option":"Bom, Regular,Ruim","type":"radio"},{"column_assunto_select":{"placeholder":"Laboratorio","option":"Bom, Regular,Ruim","type":"radio"},{"column_assunto_select":{"placeholder":"RH","option":"Bom, Regular,Ruim","type":"radio"},{"column_assunto_select":{"placeholder":"Médicos","option":"Bom, Regular,Ruim","type":"radio"},',
            'title_button_form' => 'Enviar',
            'active_form' => 1
        ];
    }
}
