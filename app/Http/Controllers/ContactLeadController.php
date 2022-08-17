<?php

namespace App\Http\Controllers;

use App\Models\ContactLead;
use App\Http\Controllers\Controller;
use App\Models\ContactForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;

class ContactLeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contactLeads = ContactLead::orderBy('created_at', 'DESC')->get();
        $contactForm = ContactForm::first();
        return view('Admin.cruds.contactLead.index', [
            'contactLeads' => $contactLeads,
            'contactForm' => $contactForm?json_decode($contactForm->inputs):null
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);

        $arrayInsert = [];
        foreach ($data as $key => $value) {
            $array = explode('_', $key);
            if(COUNT($array) >= 3 ){
                $type = end($array);
                $name = str_replace('_'.$type, '', $key);

                // $arrayInsert = array_merge($arrayInsert, [$name]);
                $arrayInsert = array_merge($arrayInsert, [$data[$name] => ['value' => $value, 'type' => $type]]);
            }
        }

        $contactLead = ContactLead::create(['json' => json_encode($arrayInsert)]);

        Session::flash('success', 'Item cadastrado com sucessso');
        return redirect()->route('cont01.confirmation');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContactLead  $ContactLead
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactLead $ContactLead)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContactLead  $ContactLead
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContactLead $ContactLead)
    {
        Session::flash('success', 'Item atualizado com sucessso');
        return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContactLead  $ContactLead
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactLead $ContactLead)
    {
        if($ContactLead->delete()){
            Session::flash('success', 'Item deletado com sucessso');
            return redirect()->back();
        }
    }

    /**
     * Remove the selected resource from storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroySelected(Request $request)
    {
        if($deleted = ContactLead::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' itens deletados com sucessso']);
        }
    }
    /**
    * Sort record by dragging and dropping
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id){
            ContactLead::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\ContactLead  $ContactLead
     * @return \Illuminate\Http\Response
     */
    public function show(ContactLead $ContactLead)
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
        //
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
}
