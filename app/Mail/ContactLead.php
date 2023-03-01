<?php

namespace App\Mail;

use App\Models\GeneralSetting;
use App\Models\SettingSmtp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactLead extends Mailable
{
    use Queueable, SerializesModels;

    protected $infomation;
    protected $emailRecipient;
    protected $contactLead;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($infomation, $emailRecipient, $contactLead)
    {
        $this->infomation = $infomation;
        $this->emailRecipient = $emailRecipient;
        $this->contactLead = $contactLead;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $generalSetting = GeneralSetting::first();
        $setting = SettingSmtp::first();
        $appName = env('APP_NAME');

        $this->subject($appName.' - Lead do site');
        $this->to($this->emailRecipient, $appName.' - Lead do site');
        $this->from($setting->user, $appName.' - Lead do site');

        foreach ($this->infomation as $value) {
            if(isset($value['type'])){
                if($value['type'] == 'file'){
                    $this->attachFromStorage($value['value'], $value['requestFile']->getClientOriginalName());
                }
            }
        }

        return $this->view('Mail.contactUs',[
            'infomrations' => $this->infomation,
            'generalSetting' => $generalSetting,
            'contactLead' => $this->contactLead,
        ]);
    }
}
