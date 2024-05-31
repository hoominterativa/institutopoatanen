<?php

namespace App\Http\Controllers\Units;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Units\UNIT05Units;
use App\Http\Controllers\Controller;
use App\Models\Units\UNIT05UnitsLink;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\Units\UNIT05UnitsContent;
use App\Models\Units\UNIT05UnitsGallery;
use App\Models\Units\UNIT05UnitsSection;
use Illuminate\Support\Facades\Response;
use App\Models\Units\UNIT05UnitsCategory;
use App\Models\Units\UNIT05UnitsSubcategory;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Http\Controllers\IncludeSectionsController;

class UNIT05Controller extends Controller
{
    protected $path = 'uploads/Units/UNIT05/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = UNIT05Units::sorting()->paginate(20);
        $categories = UNIT05UnitsCategory::sorting()->get();
        $subcategories = UNIT05UnitsSubcategory::sorting()->get();
        $section = UNIT05UnitsSection::sorting()->first();
        $galleries = UNIT05UnitsGallery::sorting()->get();
        return view('Admin.cruds.Units.UNIT05.index', [
            'units' => $units,
            'section' => $section,
            'galleries' => $galleries,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'cropSetting' => getCropImage('Units', 'UNIT05')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = UNIT05UnitsCategory::sorting()->pluck('title', 'id');
        $subcategories = UNIT05UnitsSubcategory::sorting()->pluck('title', 'id');
        return view('Admin.cruds.Units.UNIT05.create',[
            'categories' => $categories,
            'subcategories' => $subcategories,
            'cropSetting' => getCropImage('Units', 'UNIT05')
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

        $data['active'] = $request->active ? 1 : 0;
        if ($request->title || $request->subtitle) $data['slug'] = Str::slug($request->title . ' ' . ($request->subtitle ? $request->subtitle : ''));

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null,100);
        if($path_image_box) $data['path_image_box'] = $path_image_box;

        if ($units = UNIT05Units::create($data)) {
            Session::flash('success', 'Unidade cadastrada com sucesso');
            return redirect()->route('admin.unit05.edit', ['UNIT05Units' => $units->id]);
        } else {
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
            Storage::delete($path_image_box);
            Session::flash('error', 'Erro ao cadastradar a unidade');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Units\UNIT05Units  $UNIT05Units
     * @return \Illuminate\Http\Response
     */
    public function edit(UNIT05Units $UNIT05Units)
    {
        $categories = UNIT05UnitsCategory::sorting()->pluck('title', 'id');
        $subcategories = UNIT05UnitsSubcategory::sorting()->pluck('title', 'id');
        $contents = UNIT05UnitsContent::where('unit_id', $UNIT05Units->id)->sorting()->get();
        $links = UNIT05UnitsLink::where('unit_id', $UNIT05Units->id)->sorting()->get();
        return view('Admin.cruds.Units.UNIT05.edit', [
            'categories' => $categories,
            'subcategories' => $subcategories,
            'unit' => $UNIT05Units,
            'contents' => $contents,
            'links' => $links,
            'cropSetting' => getCropImage('Units', 'UNIT05')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Units\UNIT05Units  $UNIT05Units
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UNIT05Units $UNIT05Units)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;
        if ($request->title || $request->subtitle) $data['slug'] = Str::slug($request->title . ' ' . ($request->subtitle ? $request->subtitle : ''));

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($UNIT05Units, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($UNIT05Units, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($UNIT05Units, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($UNIT05Units, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        $path_image_box = $helper->optimizeImage($request, 'path_image_box', $this->path, null,100);
        if($path_image_box){
            storageDelete($UNIT05Units, 'path_image_box');
            $data['path_image_box'] = $path_image_box;
        }
        if($request->delete_path_image_box && !$path_image_box){
            storageDelete($UNIT05Units, 'path_image_box');
            $data['path_image_box'] = null;
        }

        if ($UNIT05Units->fill($data)->save()) {
            Session::flash('success', 'Unidade atualizada com sucesso');
        } else {
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
            Storage::delete($path_image_box);
            Session::flash('error', 'Erro ao atualizar a unidade');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Units\UNIT05Units  $UNIT05Units
     * @return \Illuminate\Http\Response
     */
    public function destroy(UNIT05Units $UNIT05Units)
    {
        storageDelete($UNIT05Units, 'path_image');
        storageDelete($UNIT05Units, 'path_image_icon');
        storageDelete($UNIT05Units, 'path_image_box');

        if ($UNIT05Units->delete()) {
            Session::flash('success', 'Unidade deletada com sucessso');
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

        $UNIT05Unitss = UNIT05Units::whereIn('id', $request->deleteAll)->get();
        foreach($UNIT05Unitss as $UNIT05Units){
            storageDelete($UNIT05Units, 'path_image');
            storageDelete($UNIT05Units, 'path_image_icon');
            storageDelete($UNIT05Units, 'path_image_box');
        }

        if ($deleted = UNIT05Units::whereIn('id', $request->deleteAll)->delete()) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' unidades deletadas com sucessso']);
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
            UNIT05Units::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Units\UNIT05Units  $UNIT05Units
     * @return \Illuminate\Http\Response
     */
    //public function show(UNIT05Units $UNIT05Units)
    public function show()
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Units', 'UNIT05', 'show');

        return view('Client.pages.Units.UNIT05.show', [
            'sections' => $sections
        ]);
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request, UNIT05UnitsCategory $UNIT05UnitsCategory, UNIT05UnitsSubcategory $UNIT05UnitsSubcategory)
    {
        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Units', 'UNIT05', 'page');

        if (!$UNIT05UnitsCategory->exists) {
            $UNIT05UnitsCategory = UNIT05UnitsCategory::exists()->sorting()->active()->first();
        }

        $categories = UNIT05UnitsCategory::exists()->active()->sorting()->get();
        $subcategories = UNIT05UnitsSubcategory::getSubCategoryByCategory($UNIT05UnitsCategory);
        $units = UNIT05Units::with(['links', 'category', 'subcategory'])->where('category_id', $UNIT05UnitsCategory->id)->active()->sorting()->get();
        if($UNIT05UnitsSubcategory->exists){
            $units = $units->where('subcategory_id', $UNIT05UnitsSubcategory->id);
        }
        $section = UNIT05UnitsSection::activeBanner()->sorting()->first();
        switch(deviceDetect()) {
            case "table":
            case "mobile":
                if ($section) $section->path_image_desktop_banner = $section->path_image_mobile_banner;
            break;
        }

        // dd($units);

        return view('Client.pages.Units.UNIT05.page', [
            'sections' => $sections,
            'section' => $section,
            'categories' => $categories,
            'categorySelected' => $UNIT05UnitsCategory,
            'subcategorySelected' => $UNIT05UnitsSubcategory,
            'subcategories' => $subcategories,
            'units' => $units
        ]);
    }

    /**
     * Section index resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function section()
    {
        $section = UNIT05UnitsSection::activeSection()->sorting()->first();
        $galleries = UNIT05UnitsGallery::sorting()->get();
        $categories = UNIT05UnitsCategory::exists()->active()->featured()->sorting()->get();
        $categoryFirst = UNIT05UnitsCategory::exists()->active()->featured()->sorting()->first();

        $subcategories = UNIT05UnitsSubcategory::getSubCategoryByCategory($categoryFirst);

        // dd($subcategories);

        return view('Client.pages.Units.UNIT05.section', [
            'section' => $section,
            'galleries' => $galleries,
            'categories' => $categories,
            'categoryFirst' => $categoryFirst,
            'subcategories' => $subcategories
        ]);
    }
}
