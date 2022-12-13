<?php

namespace App\Mail;

use App\Models\Social;
use App\Models\ContactLead;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\GeneralSetting;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactLeadConfirmation extends Mailable
{
    use Queueable, SerializesModels;
    protected $contactLead;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ContactLead $contactLead)
    {
        $this->contactLead = $contactLead;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $setting = GeneralSetting::first();
        $socials = Social::get();
        $appName = env('APP_NAME');
        $informations = json_decode($this->contactLead->json);
        $name = null;

        foreach ($informations as $key => $value) {
            if(($value->type??'')=='email'){
                $emailRecipient = $value->value;
            }

            switch (Str::slug($key)) {
                case 'nome':
                case 'nome-completo':
                case 'nome-sobrenome':
                    $name = $value->value;
                break;
            }
        }

        $this->subject($appName.' - Confirmação');
        $this->to($emailRecipient, $appName.' - Confirmação');
        $this->from($setting->smtp_user, $appName.' - Confirmação');

        return $this->view('Mail.contactConfirmation',[
            'contactLead' => $this->contactLead,
            'name' => $name,
            'setting' => $setting,
            'socials' => $socials,
        ]);
    }
}
