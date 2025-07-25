<?php

namespace App\Http\Controllers\Frequently;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Frequently\FREQ01Frequently;
use App\Models\Compliances\COMP01Compliances;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Frequently\FREQ01FrequentlySection;
use App\Http\Controllers\IncludeSectionsController;

class FREQ01Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $frequentlys = FREQ01Frequently::sorting()->get();
        $section = FREQ01FrequentlySection::first();
        return view('Admin.cruds.Frequently.FREQ01.index', [
            'frequentlys' => $frequentlys,
            'section' => $section,
            'cropSetting' => getCropImage('Frequently' , 'FREQ01')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Frequently.FREQ01.create');
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

        if(FREQ01Frequently::create($data)){
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.freq01.index');
        }else{
            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Frequently\FREQ01Frequently  $FREQ01Frequently
     * @return \Illuminate\Http\Response
     */
    public function edit(FREQ01Frequently $FREQ01Frequently)
    {
        return view('Admin.cruds.Frequently.FREQ01.edit', [
            'frequently' => $FREQ01Frequently
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Frequently\FREQ01Frequently  $FREQ01Frequently
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FREQ01Frequently $FREQ01Frequently)
    {
        $data = $request->all();

        $data['active'] = $request->active?1:0;

        if($FREQ01Frequently->fill($data)->save()){
            Session::flash('success', 'Item atualizado com sucesso');
        }else{
            Session::flash('error', 'Erro ao atualizar item');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Frequently\FREQ01Frequently  $FREQ01Frequently
     * @return \Illuminate\Http\Response
     */
    public function destroy(FREQ01Frequently $FREQ01Frequently)
    {

        if($FREQ01Frequently->delete()){
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
        if($deleted = FREQ01Frequently::whereIn('id', $request->deleteAll)->delete()){
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
            FREQ01Frequently::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Frequently', 'FREQ01');

        $frequentlys = FREQ01Frequently::active()->sorting()->get();
        $compliances = COMP01Compliances::sorting()->first();
        $compliances = getCompliance($compliances->id);
        $section = FREQ01FrequentlySection::active()->first();
        $sectionForm = FREQ01FrequentlySection::activeForm()->first();

        switch (deviceDetect()) {
            case 'mobile':
            case 'tablet':
                if($section) $section->path_image_desktop = $section->path_image_mobile;
            break;
        }

        return view('Client.pages.Frequently.FREQ01.page',[
            'sections' => $sections,
            'section' => $section,
            'sectionForm' => $sectionForm,
            'frequentlys' => $frequentlys,
            'compliances' => $compliances
        ]);
    }
}
