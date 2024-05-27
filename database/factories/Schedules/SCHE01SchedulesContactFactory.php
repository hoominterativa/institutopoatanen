<?php

namespace Database\Factories\Schedules;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Schedules\SCHE01SchedulesContact;

class SCHE01SchedulesContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SCHE01SchedulesContact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // return [
        //     'title' => $this->faker->text(10),
        //     'subtitle' => $this->faker->text(10),
        //     'description' => $this->faker->text(10),
        //     'title_button' => 'Enviar',
        //     "inputs_form" => '{"column_nome_text":{"placeholder":"Nome","option":"","type":"text"},"column_e-mail_email":{"placeholder":"E-mail","option":"","type":"email"},"column_celular_cellphone":{"placeholder":"Celular","option":"","type":"cellphone"},"column_assunto_select":{"placeholder":"Assunto","option":"Duvidas, Reclama\u00e7\u00f5es, Or\u00e7amentos","type":"select"},"column_mensagem_textarea":{"placeholder":"Mensagem","option":"","type":"textarea"}}',
        //     "email_form" => $this->faker->email(),
        //     'active' => 1,
        // ];
    }
}
