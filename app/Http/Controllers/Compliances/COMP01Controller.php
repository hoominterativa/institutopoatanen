<?php

namespace App\Http\Controllers\Compliances;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Compliances\COMP01Compliances;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Compliances\COMP01CompliancesArchive;

class COMP01Controller extends Controller
{
    protected $path = 'uploads/Compliances/COMP01/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $compliances = COMP01Compliances::sorting()->get();
        return view('Admin.cruds.Compliances.COMP01.index',[
            'compliances' => $compliances
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Compliances.COMP01.create');
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

        $path_image_banner = $helper->optimizeImage($request, 'path_image_banner', $this->path, null, 100);
        if($path_image_banner) $data['path_image_banner'] = $path_image_banner;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null, 100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        $data['slug'] = Str::slug($request->title_page);
        $data['active'] = $request->active?1:0;
        $data['show_footer'] = $request->show_footer?1:0;

        if($compliance = COMP01Compliances::create($data)){
            Session::flash('success', 'Informações cadastradas com sucesso');
            return redirect()->route('admin.comp01.edit', ['COMP01Compliances' => $compliance]);
        }else{
            Storage::delete($path_image_banner);
            Storage::delete($path_image_icon);
            Session::flash('success', 'Erro ao cadastradar informações');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Compliances\COMP01Compliances  $COMP01Compliances
     * @return \Illuminate\Http\Response
     */
    public function edit(COMP01Compliances $COMP01Compliances)
    {
        $archives = COMP01CompliancesArchive::where('compliance_id', $COMP01Compliances->id)->sorting()->get();
        return view('Admin.cruds.Compliances.COMP01.edit',[
            'compliance' => $COMP01Compliances,
            'archives' => $archives
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compliances\COMP01Compliances  $COMP01Compliances
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, COMP01Compliances $COMP01Compliances)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $path_image_banner = $helper->optimizeImage($request, 'path_image_banner', $this->path, null, 100);
        if($path_image_banner){
            storageDelete($COMP01Compliances, 'path_image_banner');
            $data['path_image_banner'] = $path_image_banner;
        }
        if($request->delete_path_image_banner && !$path_image_banner){
            storageDelete($COMP01Compliances, 'path_image_banner');
            $data['path_image_banner'] = null;
        }

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null, 100);
        if($path_image_icon){
            storageDelete($COMP01Compliances, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($COMP01Compliances, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        $data['slug'] = Str::slug($request->title_page);
        $data['active'] = $request->active?1:0;
        $data['show_footer'] = $request->show_footer?1:0;

        if($COMP01Compliances->fill($data)->save()){
            Session::flash('success', 'Informações atualizadas com sucesso');
        }else{
            Storage::delete($path_image_banner);
            Storage::delete($path_image_icon);
            Session::flash('error', 'Erro ao atualizar informações');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Compliances\COMP01Compliances  $COMP01Compliances
     * @return \Illuminate\Http\Response
     */
    public function destroy(COMP01Compliances $COMP01Compliances)
    {
        storageDelete($COMP01Compliances, 'path_image_banner');
        storageDelete($COMP01Compliances, 'path_image_icon');

        if($COMP01Compliances->delete()){
            Session::flash('success', 'Página deletada com sucessso');
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
        $COMP01Compliancess = COMP01Compliances::whereIn('id', $request->deleteAll)->get();
        foreach($COMP01Compliancess as $COMP01Compliances){
            storageDelete($COMP01Compliances, 'path_image_banner');
            storageDelete($COMP01Compliances, 'path_image_icon');
        }

        if($deleted = COMP01Compliances::whereIn('id', $request->deleteAll)->delete()){
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
            COMP01Compliances::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Compliances\COMP01Compliances  $COMP01Compliances
     * @return \Illuminate\Http\Response
     */
    public function show(COMP01Compliances $COMP01Compliances)
    {
        $archives = COMP01CompliancesArchive::where('compliance_id', $COMP01Compliances->id)->sorting()->get();
        return view('Client.pages.Compliances.COMP01.show',[
            'compliance' => $COMP01Compliances,
            'archives' => $archives
        ]);
    }
}
