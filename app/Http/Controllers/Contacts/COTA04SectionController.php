<?php

namespace App\Http\Controllers\Contacts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use CreateCota04ContactsSectionsTable;
use App\Models\Contacts\COTA04Contacts;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Contacts\COTA04ContactsForm;
use App\Models\Contacts\COTA04ContactsSection;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Contacts\COTA04ContactsCategory;
use App\Http\Controllers\IncludeSectionsController;

class COTA04SectionController extends Controller
{
    protected $path = 'uploads/Contacts/COTA04/images/';

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(COTA04Contacts $COTA04Contacts)
    {
        return view('Admin.cruds.Contacts.COTA04.Sections.create', [
            'contact' => $COTA04Contacts,
        ]);
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
        $data['active'] = $request->active?1:0;

        if($section = COTA04ContactsSection::create($data)){
            Session::flash('success', 'Seção cadastrada com sucesso');
            return redirect()->route('admin.cota04.section.edit', ['COTA04ContactsSection' => $section->id]);
        }else{
            Session::flash('error', 'Erro ao cadastradar a seção');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contacts\COTA04ContactsSection  $COTA04ContactsSection
     * @return \Illuminate\Http\Response
     */
    public function edit(COTA04ContactsSection $COTA04ContactsSection)
    {
        $contact = COTA04Contacts::find($COTA04ContactsSection->contact_id);
        $serviceCategories = COTA04ContactsCategory::where('section_id', $COTA04ContactsSection->id)->sorting()->get();
        $categories = COTA04ContactsCategory::where('section_id', $COTA04ContactsSection->id)->sorting()->pluck('title', 'id');
        $forms = COTA04ContactsForm::where('section_id', $COTA04ContactsSection->id)->sorting()->get();
        foreach ($forms as $form) {
            $form->inputs_form = json_decode($form->inputs_form);
        }

        return view('Admin.cruds.Contacts.COTA04.Sections.edit',[
            'section' => $COTA04ContactsSection,
            'contact' => $contact,
            'serviceCategories' => $serviceCategories,
            'categories' => $categories,
            'forms' => $forms,
            'cropSetting' => getCropImage('Contacts', 'COTA04'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contacts\COTA04ContactsSection  $COTA04ContactsSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, COTA04ContactsSection $COTA04ContactsSection)
    {
        $data = $request->all();

        if($COTA04ContactsSection->fill($data)->save()){
            Session::flash('success', 'Seção atualizada com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar a seção');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contacts\COTA04ContactsSection  $COTA04ContactsSection
     * @return \Illuminate\Http\Response
     */
    public function destroy(COTA04ContactsSection $COTA04ContactsSection)
    {

        $forms = COTA04ContactsForm::where('section_id', $COTA04ContactsSection->id)->get();
        if ($forms){
            foreach ($forms as $form){
               $form->delete();
            }
        }

        $categories = COTA04ContactsCategory::where('section_id', $COTA04ContactsSection->id)->get();
        if($categories){
            foreach($categories as $category){
                storageDelete($category, 'path_image');
                $category->delete();
            }
        }


        if($COTA04ContactsSection->delete()){
            Session::flash('success', 'Seção deletada com sucessso');
            return redirect()->back();
        }
    }

    /**
     * Remove the selected resources from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroySelected(Request $request)
    {
        $COTA04ContactsSections = COTA04ContactsSection::whereIn('id', $request->deleteAll)->get();
        foreach($COTA04ContactsSections as $COTA04ContactsSection){
            $forms = COTA04ContactsForm::where('section_id', $COTA04ContactsSection->id)->get();
            if ($forms){
                foreach ($forms as $form){
                $form->delete();
                }
            }
            
            $categories = COTA04ContactsCategory::where('section_id', $COTA04ContactsSection->id)->get();
            if($categories){
                foreach($categories as $category){
                    storageDelete($category, 'path_image');
                    $category->delete();
                }
            }
        }

        if($deleted = COTA04ContactsSection::whereIn('id', $request->deleteAll)->delete()){
            return Response::json(['status' => 'success', 'message' => $deleted.' Seções deletados com sucessso']);
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
            COTA04ContactsSection::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
