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
        $contactCategories = COTA04ContactsCategory::sorting()->paginate(10);
        $categories = COTA04ContactsCategory::exists()->sorting()->pluck('title', 'id');
        return view('Admin.cruds.Contacts.COTA04.index',[
            'contacts' => $contacts,
            'contactCategories' => $contactCategories,
            'categories' => $categories,
            'cropSetting' => getCropImage('Contacts', 'COTA04')
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
        $categories = COTA04ContactsCategory::sorting()->pluck('title', 'id');
        return view('Admin.cruds.Contacts.COTA04.create', [
            'compliances' => $compliances,
            'categories' => $categories,
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

        $arrayInputs = [];

        foreach ($data as $name => $value) {
            $arrayName = explode('_', $name);
            if($arrayName[0] == 'column'){
                $type = end($arrayName);
                $inputOption = str_replace('column', 'option', $name);
                $inputRequired = str_replace('column', 'required', $name);
                $option = '';
                if(isset($data[$inputOption])){
                    $option = $data[$inputOption];
                }
                if(isset($data[$inputRequired])){
                    $required = true;
                }
                $pushArray = [
                    $name => [
                        'placeholder' => $value,
                        'option' => $option,
                        'type' => $type,
                        'required' => $required?? false,
                    ]
                ];
                $arrayInputs = array_merge($arrayInputs, $pushArray);
            }
        }
        $jsonInputs = json_encode($arrayInputs);

        $data['inputs_form'] = $jsonInputs;
        $data['slug'] = Str::slug($request->title_banner);
        $data['active'] = $request->active?1:0;

        $path_image_banner_desktop = $helper->optimizeImage($request, 'path_image_banner_desktop', $this->path, null,100);
        if($path_image_banner_desktop) $data['path_image_banner_desktop'] = $path_image_banner_desktop;

        $path_image_banner_mobile = $helper->optimizeImage($request, 'path_image_banner_mobile', $this->path, null,100);
        if($path_image_banner_mobile) $data['path_image_banner_mobile'] = $path_image_banner_mobile;

        $path_image_content = $helper->optimizeImage($request, 'path_image_content', $this->path, null,100);
        if($path_image_content) $data['path_image_content'] = $path_image_content;

        $path_image_compliance_icon = $helper->optimizeImage($request, 'path_image_compliance_icon', $this->path, null,100);
        if($path_image_compliance_icon) $data['path_image_compliance_icon'] = $path_image_compliance_icon;

        if($contact = COTA04Contacts::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.cota04.edit', ['COTA04Contacts' => $contact->id]);

        }else{
            Storage::delete($path_image_banner_desktop);
            Storage::delete($path_image_banner_mobile);
            Storage::delete($path_image_content);
            Storage::delete($path_image_compliance_icon);
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
        $configForm = json_decode($COTA04Contacts->inputs_form);
        $compliances = getCompliance(null, 'id', 'title_page');
        $categories = COTA04ContactsCategory::sorting()->pluck('title', 'id');
        return view('Admin.cruds.Contacts.COTA04.edit', [
            'contact' => $COTA04Contacts,
            'compliances' => $compliances,
            'categories' => $categories,
            'configForm' => !is_array($configForm)?$configForm:null,
            'cropSetting' => getCropImage('Contacts', 'COTA03')
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
        $arrayInputs = [];

        foreach ($data as $name => $value) {
            $arrayName = explode('_', $name);
            if($arrayName[0] == 'column'){
                $type = end($arrayName);
                $inputOption = str_replace('column', 'option', $name);
                $inputRequired = str_replace('column', 'required', $name);
                $option = '';
                $required = false;

                if(isset($data[$inputOption])){
                    $option = $data[$inputOption];
                }
                if(isset($data[$inputRequired])){
                    $required = true;
                }

                $pushArray = [
                    $name => [
                        'placeholder' => $value,
                        'option' => $option,
                        'type' => $type,
                        'required' => $required?? false,
                    ]
                ];
                $arrayInputs = array_merge($arrayInputs, $pushArray);
            }
        }

        if(count($arrayInputs)){
            $jsonInputs = json_encode($arrayInputs);
            $data['inputs_form'] = $jsonInputs;
        }
        if($request->active){
            $data['active'] = $request->active?1:0;
        }

        $data['slug'] = Str::slug($request->title_banner);

        //Banner
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

        //Content
        $path_image_content = $helper->optimizeImage($request, 'path_image_content', $this->path, null,100);
        if($path_image_content){
            storageDelete($COTA04Contacts, 'path_image_content');
            $data['path_image_content'] = $path_image_content;
        }
        if($request->delete_path_image_content && !$path_image_content){
            storageDelete($COTA04Contacts, 'path_image_content');
            $data['path_image_content'] = null;
        }

        $path_image_compliance_icon = $helper->optimizeImage($request, 'path_image_compliance_icon', $this->path, null,100);
        if($path_image_compliance_icon){
            storageDelete($COTA04Contacts, 'path_image_compliance_icon');
            $data['path_image_compliance_icon'] = $path_image_compliance_icon;
        }
        if($request->delete_path_image_compliance_icon && !$path_image_compliance_icon){
            storageDelete($COTA04Contacts, 'path_image_compliance_icon');
            $data['path_image_compliance_icon'] = null;
        }

        if($COTA04Contacts->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
        }else{
            Storage::delete($path_image_banner_desktop);
            Storage::delete($path_image_banner_mobile);
            Storage::delete($path_image_content);
            Storage::delete($path_image_compliance_icon);
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
        storageDelete($COTA04Contacts, 'path_image_banner_desktop');
        storageDelete($COTA04Contacts, 'path_image_banner_mobile');
        storageDelete($COTA04Contacts, 'path_image_content');
        storageDelete($COTA04Contacts, 'path_image_compliance_icon');

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
            storageDelete($COTA04Contacts, 'path_image_banner_desktop');
            storageDelete($COTA04Contacts, 'path_image_banner_mobile');
            storageDelete($COTA04Contacts, 'path_image_content');
            storageDelete($COTA04Contacts, 'path_image_compliance_icon');
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
    public function show()
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Contacts', 'COTA04', 'show');

        return view('Client.pages.Contacts.COTA04.show',[
            'sections' => $sections
        ]);
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Contacts', 'COTA04', 'page');

        return view('Client.pages.Contacts.COTA04.page',[
            'sections' => $sections
        ]);
    }
}
