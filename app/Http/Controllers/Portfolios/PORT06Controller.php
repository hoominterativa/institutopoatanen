<?php

namespace App\Http\Controllers\Portfolios;

use App\Models\Portfolios\PORT06Portfolios;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;
//
use App\Models\Portfolios\PORT06PortfoliosSection;
use App\Models\Portfolios\PORT06PortfoliosGallery;
use App\Models\Portfolios\PORT06PortfoliosCategory;


class PORT06Controller extends Controller
{
    protected $path = 'uploads/Module/Code/images/';

    public function index()
    {
        $portfolios = PORT06Portfolios::sorting()->paginate(20);
        $sections = PORT06PortfoliosSection::firstOrCreate();
        $categories = PORT06PortfoliosCategory::sorting()->get();
        $galleries = PORT06PortfoliosGallery::sorting()->get();
        return view('Admin.cruds.Portfolios.PORT06.index', [
            'portfolios' => $portfolios,
            'section' => $sections,
            'categories' => $categories,
            'galleries' => $galleries,
            'cropSetting' => getCropImage('Portfolios', 'PORT05')
        ]);
    }

    public function create()
    {
        $categories = PORT06PortfoliosCategory::sorting()->pluck('title', 'id');
        return view('Admin.cruds.Portfolios.PORT06.create', [
            'categories' => $categories
        ]);
    }
    public function store(Request $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($data['title']);

        $data['active'] = $request->active ? 1 : 0;

        $helper = new HelperArchive();

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if ($path_image) $data['path_image'] = $path_image;


        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null, 100);
        if ($path_image_box) $data['path_image_box'] = $path_image_box;


        if (PORT06Portfolios::create($data)) {
            Session::flash('success', 'Item cadastrado com sucesso');
            return redirect()->route('admin.code.index');
        } else {
            Storage::delete($path_image);
            Storage::delete($path_image_box);
            Session::flash('error', 'Erro ao cadastradar o item');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Portfolios\PORT06Portfolios  $PORT06Portfolios
     * @return \Illuminate\Http\Response
     */
    public function edit(PORT06Portfolios $PORT06Portfolios)
    {
        $categories = PORT06PortfoliosCategory::sorting()->pluck('title', 'id');
        return view('Admin.cruds.Portfolios.PORT06.edit', [
            'categories' => $categories,
            'portifolio' => $PORT06Portfolios,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portfolios\PORT06Portfolios  $PORT06Portfolios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PORT06Portfolios $PORT06Portfolios)
    {
        $data = $request->all();
        $data['active'] = $request->active ? 1 : 0;

        $helper = new HelperArchive();
        $data['slug'] = Str::slug($data['title']);
        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if ($path_image) {
            storageDelete($PORT06Portfolios, 'path_image');
            $data['path_image'] = $path_image;
        }
        if ($request->delete_path_image && !$path_image) {
            storageDelete($PORT06Portfolios, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_box = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if ($path_image_box) {
            storageDelete($PORT06Portfolios, 'path_image_box');
            $data['path_image_box'] = $path_image_box;
        }
        if ($request->delete_path_image_box && !$path_image_box) {
            storageDelete($PORT06Portfolios, 'path_image_box');
            $data['path_image_box'] = null;
        }



        if ($PORT06Portfolios->fill($data)->save()) {
            Session::flash('success', 'Item atualizado com sucesso');
            return redirect()->back();
        } else {
            Storage::delete($path_image);
            Storage::delete($path_image_box);
            Session::flash('error', 'Erro ao atualizar item');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portfolios\PORT06Portfolios  $PORT06Portfolios
     * @return \Illuminate\Http\Response
     */
    public function destroy(PORT06Portfolios $PORT06Portfolios)
    {
        storageDelete($PORT06Portfolios, 'path_image');
        storageDelete($PORT06Portfolios, 'path_image_box');

        if ($PORT06Portfolios->delete()) {
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

        $PORT06Portfolioss = PORT06Portfolios::whereIn('id', $request->deleteAll)->get();
        foreach ($PORT06Portfolioss as $PORT06Portfolios) {
            storageDelete($PORT06Portfolios, 'path_image');
            storageDelete($PORT06Portfolios, 'path_image_box');
        }


        if ($deleted = PORT06Portfolios::whereIn('id', $request->deleteAll)->delete()) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' itens deletados com sucessso']);
        }
    }
    public function sorting(Request $request)
    {
        foreach ($request->arrId as $sorting => $id) {
            PORT06Portfolios::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Portfolios\PORT06Portfolios  $PORT06Portfolios
     * @return \Illuminate\Http\Response
     */
    //public function show(PORT06Portfolios $PORT06Portfolios)
    public function show()
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Portfolios', 'PORT06', 'show');

        return view('Client.pages.Portfolios.PORT06.show', [
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
        $sections = $IncludeSectionsController->IncludeSectionsPage('Portfolios', 'PORT06', 'page');

        return view('Client.pages.Portfolios.PORT06.page', [
            'sections' => $sections
        ]);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        return view('Client.pages.Portfolios.PORT06.section');
    }
}
