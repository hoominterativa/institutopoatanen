<?php

namespace App\Http\Controllers\Contacts;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contacts\COTA04Contacts;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Contacts\COTA04ContactsCategory;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Contacts\COTA04ContactsForm;
use App\Models\Contacts\COTA04ContactsSection;

class COTA04Controller extends Controller
{
    protected $path = 'uploads/Contacts/COTA04/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = COTA04Contacts::sorting()->get();
        return view('Admin.cruds.Contacts.COTA04.index',[
            'contacts' => $contacts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $compliances = getCompliance(null, 'id', 'title_page');
        return view('Admin.cruds.Contacts.COTA04.create', [
            'compliances' => $compliances,
            'cropSetting' => getCropImage('Contacts', 'COTA04')
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
        $helper = new HelperArchive();
        $data['slug'] = Str::slug($request->title_banner);
        $data['active'] = $request->active?1:0;

        $path_image_banner_desktop = $helper->optimizeImage($request, 'path_image_banner_desktop', $this->path, null,100);
        if($path_image_banner_desktop) $data['path_image_banner_desktop'] = $path_image_banner_desktop;

        $path_image_banner_mobile = $helper->optimizeImage($request, 'path_image_banner_mobile', $this->path, null,100);
        if($path_image_banner_mobile) $data['path_image_banner_mobile'] = $path_image_banner_mobile;

        $path_image_content = $helper->optimizeImage($request, 'path_image_content', $this->path, null,100);
        if($path_image_content) $data['path_image_content'] = $path_image_content;

        if($contact = COTA04Contacts::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.cota04.edit', ['COTA04Contacts' => $contact->id]);

        }else{
            Storage::delete($path_image_banner_desktop);
            Storage::delete($path_image_banner_mobile);
            Storage::delete($path_image_content);
            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contacts\COTA04Contacts  $COTA04Contacts
     * @return \Illuminate\Http\Response
     */
    public function edit(COTA04Contacts $COTA04Contacts)
    {
        $compliances = getCompliance(null, 'id', 'title_page');
        $sections = COTA04ContactsSection::where('contact_id', $COTA04Contacts->id)->sorting()->get();
        return view('Admin.cruds.Contacts.COTA04.edit', [
            'contact' => $COTA04Contacts,
            'compliances' => $compliances,
            'cropSetting' => getCropImage('Contacts', 'COTA04'),
            'sections' => $sections,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contacts\COTA04Contacts  $COTA04Contacts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, COTA04Contacts $COTA04Contacts)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;

        $data['slug'] = Str::slug($request->title_banner);

        $path_image_banner_desktop = $helper->optimizeImage($request, 'path_image_banner_desktop', $this->path, null,100);
        if($path_image_banner_desktop){
            storageDelete($COTA04Contacts, 'path_image_banner_desktop');
            $data['path_image_banner_desktop'] = $path_image_banner_desktop;
        }
        if($request->delete_path_image_banner_desktop && !$path_image_banner_desktop){
            storageDelete($COTA04Contacts, 'path_image_banner_desktop');
            $data['path_image_banner_desktop'] = null;
        }

        $path_image_banner_mobile = $helper->optimizeImage($request, 'path_image_banner_mobile', $this->path, null,100);
        if($path_image_banner_mobile){
            storageDelete($COTA04Contacts, 'path_image_banner_mobile');
            $data['path_image_banner_mobile'] = $path_image_banner_mobile;
        }
        if($request->delete_path_image_banner_mobile && !$path_image_banner_mobile){
            storageDelete($COTA04Contacts, 'path_image_banner_mobile');
            $data['path_image_banner_mobile'] = null;
        }

        $path_image_content = $helper->optimizeImage($request, 'path_image_content', $this->path, null,100);
        if($path_image_content){
            storageDelete($COTA04Contacts, 'path_image_content');
            $data['path_image_content'] = $path_image_content;
        }
        if($request->delete_path_image_content && !$path_image_content){
            storageDelete($COTA04Contacts, 'path_image_content');
            $data['path_image_content'] = null;
        }

        if($COTA04Contacts->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
        }else{
            Storage::delete($path_image_banner_desktop);
            Storage::delete($path_image_banner_mobile);
            Storage::delete($path_image_content);
            Session::flash('error', 'Erro ao atualizar item');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contacts\COTA04Contacts  $COTA04Contacts
     * @return \Illuminate\Http\Response
     */
    public function destroy(COTA04Contacts $COTA04Contacts)
    {
        $sections = COTA04ContactsSection::where('contact_id', $COTA04Contacts->id)->get();
        if($sections) {
            foreach($sections as $section){
                foreach($section->forms as $form){
                    $form->delete();
                }
                foreach($section->categories as $category){
                    storageDelete($category, 'path_image');
                    $category->delete();
                }
                $section->delete();
            }
        }

        storageDelete($COTA04Contacts, 'path_image_banner_desktop');
        storageDelete($COTA04Contacts, 'path_image_banner_mobile');
        storageDelete($COTA04Contacts, 'path_image_content');

        if($COTA04Contacts->delete()){
            Session::flash('success', 'Item deletado com sucessso');
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
        $COTA04Contactss = COTA04Contacts::whereIn('id', $request->deleteAll)->get();
        foreach($COTA04Contactss as $COTA04Contacts){
            $sections = COTA04ContactsSection::where('contact_id', $COTA04Contacts->id)->get();
            if($sections) {
                foreach($sections as $section){
                    foreach($section->forms as $form){
                        $form->delete();
                    }
                    foreach($section->categories as $category){
                        storageDelete($category, 'path_image');
                        $category->delete();
                    }
                    $section->delete();
                }
            }

            storageDelete($COTA04Contacts, 'path_image_banner_desktop');
            storageDelete($COTA04Contacts, 'path_image_banner_mobile');
            storageDelete($COTA04Contacts, 'path_image_content');
        }

        if($deleted = COTA04Contacts::whereIn('id', $request->deleteAll)->delete()){
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
            COTA04Contacts::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Contacts\COTA04Contacts  $COTA04Contacts
     * @return \Illuminate\Http\Response
     */
    //public function show(COTA04Contacts $COTA04Contacts)
    public function show(COTA04Contacts $COTA04Contacts)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Contacts', 'COTA04', 'show');

        $contact = COTA04Contacts::active()->sorting()->first();
        $sectionss = COTA04ContactsSection::with(['categories' => function($query){$query->where('active', 1);}, 'forms' => function($query){$query->where('active', 1);}] )
            ->where('contact_id', $contact->id)->active()->sorting()->get();

        $compliance = getCompliance($contact->compliance_id??'0');
        switch(deviceDetect()){
            case 'mobile':
            case 'tablet':
                if ($COTA04Contacts->path_image_banner_mobile != ''){
                    $COTA04Contacts->path_image_banner_desktop = $COTA04Contacts->path_image_banner_mobile;
                }
                break;
        }

        return view('Client.pages.Contacts.COTA04.page',[
            'sections' => $sections,
            'contact' => $contact,
            'compliance' => $compliance,
            'sectionss' =>$sectionss,
        ]);
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request, COTA04Contacts $COTA04Contacts)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Contacts', 'COTA04', 'page');

        $contact = COTA04Contacts::active()->sorting()->first();
        $sectionss = COTA04ContactsSection::with(['categories' => function($query){$query->where('active', 1);}, 'forms' => function($query){$query->where('active', 1);}] )
            ->where('contact_id', $contact->id)->active()->sorting()->get();

        $compliance = getCompliance($contact->compliance_id??'0');
        switch(deviceDetect()){
            case 'mobile':
            case 'tablet':
                if ($contact->path_image_banner_mobile != ''){
                    $contact->path_image_banner_desktop = $contact->path_image_banner_mobile;
                }
                break;
        }

        return view('Client.pages.Contacts.COTA04.page',[
            'sections' => $sections,
            'contact' => $contact,
            'compliance' => $compliance,
            'sectionss' =>$sectionss,
        ]);
    }
}
