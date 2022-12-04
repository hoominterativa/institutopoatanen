<?php

namespace App\Mail;

use App\Models\GeneralSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactLead extends Mailable
{
    use Queueable, SerializesModels;

    protected $infomation;
    protected $emailRecipient;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($infomation, $emailRecipient)
    {
        $this->infomation = $infomation;
        $this->emailRecipient = $emailRecipient;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $setting = GeneralSetting::first();
        $appName = env('APP_NAME');

        $this->subject($appName.' - Lead do site');
        $this->to($this->emailRecipient, $appName.' - Lead do site');
        $this->from($setting->smtp_user, $appName.' - Lead do site');

        foreach ($this->infomation as $value) {
            if(isset($value['type'])){
                if($value['type'] == 'file'){
                    $this->attachFromStorage($value['value'], $value['requestFile']->getClientOriginalName());
                }
            }
        }

        return $this->view('Mail.contactUs',[
            'infomrations' => $this->infomation,
            'setting' => $setting,
        ]);
    }
}
