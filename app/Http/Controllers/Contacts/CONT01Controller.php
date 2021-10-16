<?php

namespace App\Http\Controllers\Contacts;

use App\Http\Controllers\Controller;
use App\Models\ContactForm;
use App\Models\Social;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class CONT01Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request)
    {
        $contactForm = ContactForm::first();
        $socials = Social::all();

        // Treats subject options
        $optionsSubject = json_decode($contactForm->inputs)->subject->option;
        $arrOptSubject = explode(',', $optionsSubject);
        $subject = [];
        if($optionsSubject){
            foreach ($arrOptSubject as $valueSubject) {
                $subject = array_merge($subject, [ltrim(rtrim($valueSubject)) => ltrim(rtrim($valueSubject))]);
            }
        }

        // Treats met us options
        $optionsMetUs = json_decode($contactForm->inputs)->subject->option;
        $arrOptMetUs = explode(',', $optionsMetUs);
        $metUs = [];
        if($optionsSubject){
            foreach ($arrOptMetUs as $valueMetUs) {
                $metUs = array_merge($metUs, [ltrim(rtrim($valueMetUs)) => ltrim(rtrim($valueMetUs))]);
            }
        }

        return view('Client.pages.Contacts.CONT01.page',[
            'contactForm' => json_decode($contactForm->inputs),
            'subject' => $subject,
            'metUs' => $metUs,
            'socials' => $socials,
        ]);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        return view('');
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function confirmation()
    {
        return view('Client.pages.Contacts.CONT01.confirmation');
    }
}
