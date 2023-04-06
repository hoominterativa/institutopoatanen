<?php

namespace App\Http\Controllers\Contents;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contents\CONT10Contents;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Contents\CONT10ContentsSection;

class CONT10Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents = CONT10Contents::sorting()->paginate(15);
        $section = CONT10ContentsSection::first();
        return view('Admin.cruds.Contents.CONT10.index', [
            'contents' => $contents,
            'section' => $section,
            'cropSetting' => getCropImage('Contents', 'CONT10')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.cruds.Contents.CONT10.create');
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

        $date['active'] = $request->active ? 1 : 0;
        $data['date'] = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d');

        if (CONT10Contents::create($data)) {
            Session::flash('success', 'Conteúdo cadastrado com sucesso');
            return redirect()->route('admin.cont10.index');
        } else {
            Session::flash('error', 'Erro ao cadastradar o conteúdo');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contents\CONT10Contents  $CONT10Contents
     * @return \Illuminate\Http\Response
     */
    public function edit(CONT10Contents $CONT10Contents)
    {
        $CONT10Contents->date = Carbon::parse($CONT10Contents->date)->format('d/m/Y');
        return view('Admin.cruds.Contents.CONT10.edit', [
            'content' => $CONT10Contents
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contents\CONT10Contents  $CONT10Contents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CONT10Contents $CONT10Contents)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $date['active'] = $request->active ? 1 : 0;
        $data['date'] = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d');

        if ($CONT10Contents->fill($data)->save()) {
            Session::flash('success', 'Conteúdo atualizado com sucesso');
        } else {
            Session::flash('error', 'Erro ao atualizar o conteúdo');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contents\CONT10Contents  $CONT10Contents
     * @return \Illuminate\Http\Response
     */
    public function destroy(CONT10Contents $CONT10Contents)
    {

        if ($CONT10Contents->delete()) {
            Session::flash('success', 'Conteúdo deletado com sucessso');
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

        if ($deleted = CONT10Contents::whereIn('id', $request->deleteAll)->delete()) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' Conteúdos deletados com sucessso']);
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
        foreach ($request->arrId as $sorting => $id) {
            CONT10Contents::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT
    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        switch (deviceDetect()) {
            case 'mobile':
            case 'tablet':
                $section = CONT10ContentsSection::active()->first();
                $section->path_image_desktop = $section->path_image_mobile;
                break;
            default:
                $section = CONT10ContentsSection::active()->first();
                break;
        }

        $contents = CONT10Contents::active()->sorting()->get();
        return view('Client.pages.Contents.CONT10.section', [
            'contents' => $contents,
            'section' => $section
        ]);
    }
}
