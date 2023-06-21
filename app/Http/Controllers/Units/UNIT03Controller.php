<?php

namespace App\Http\Controllers\Units;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Units\UNIT03Units;
use App\Http\Controllers\Controller;
use App\Models\Units\UNIT03UnitsTopic;
use App\Models\Units\UNIT03UnitsBanner;
use App\Models\Units\UNIT03UnitsSocial;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\Units\UNIT03UnitsContact;
use App\Models\Units\UNIT03UnitsContent;
use App\Models\Units\UNIT03UnitsGallery;
use Illuminate\Support\Facades\Response;
use App\Models\Units\UNIT03UnitsCategory;
use App\Models\Units\UNIT03UnitsBannerShow;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Units\UNIT03UnitsGalleryContent;
use App\Models\Units\UNIT03UnitsSectionGallery;
use App\Http\Controllers\IncludeSectionsController;

class UNIT03Controller extends Controller
{
    protected $path = 'uploads/Units/UNIT03/images/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = UNIT03Units::sorting()->paginate(20);
        $unitsCategories = UNIT03UnitsCategory::sorting()->get();
        $categories = UNIT03UnitsCategory::exists()->sorting()->pluck('title', 'id');
        $banner = UNIT03UnitsBanner::first();

        return view('Admin.cruds.Units.UNIT03.index', [
            'units' => $units,
            'unitsCategories' => $unitsCategories,
            'categories' => $categories,
            'banner' => $banner,
            'cropSetting' => getCropImage('Units', 'UNIT03')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = UNIT03UnitsCategory::exists()->sorting()->pluck('title', 'id');
        return view('Admin.cruds.Units.UNIT03.create', [
            'categories' => $categories,
            'cropSetting' => getCropImage('Units', 'UNIT03')
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
        $data['slug'] = Str::slug($data['title']);

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if ($path_image) $data['path_image'] = $path_image;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null, 100);
        if ($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        $path_image_icon_show = $helper->optimizeImage($request, 'path_image_icon_show', $this->path, null, 100);
        if ($path_image_icon_show) $data['path_image_icon_show'] = $path_image_icon_show;

        $path_image_gallery = $helper->optimizeImage($request, 'path_image_gallery', $this->path, null, 100);
        if ($path_image_gallery) $data['path_image_gallery'] = $path_image_gallery;

        if ($unit = UNIT03Units::create($data)) {
            Session::flash('success', 'Unidade cadastrada com sucesso');
            return redirect()->route('admin.unit03.index', ['UNIT03Units' => $unit->id]);
        } else {
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
            Storage::delete($path_image_icon_show);
            Storage::delete($path_image_gallery);
            Session::flash('error', 'Erro ao cadastradar a unidade');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Units\UNIT03Units  $UNIT03Units
     * @return \Illuminate\Http\Response
     */
    public function edit(UNIT03Units $UNIT03Units)
    {
        $categories = UNIT03UnitsCategory::exists()->sorting()->pluck('title', 'id');
        $topics = UNIT03UnitsTopic::where('unit_id', $UNIT03Units->id)->sorting()->get();
        $socials = UNIT03UnitsSocial::where('unit_id', $UNIT03Units->id)->sorting()->get();
        $bannerShow = UNIT03UnitsBannerShow::where('unit_id', $UNIT03Units->id)->first();
        $contents = UNIT03UnitsContent::with('galleryContents')->where('unit_id', $UNIT03Units->id)->sorting()->get();
        $galleries = UNIT03UnitsGallery::where('unit_id', $UNIT03Units->id)->sorting()->get();
        $sectionGallery = UNIT03UnitsSectionGallery::where('unit_id', $UNIT03Units->id)->first();
        $contact = UNIT03UnitsContact::where('unit_id', $UNIT03Units->id)->first();
        $configForm = null;
        if ($contact) {
            $configForm = $contact->inputs_form ? json_decode($contact->inputs_form) : [];
        }
        return view('Admin.cruds.Units.UNIT03.edit', [
            'unit' => $UNIT03Units,
            'categories' => $categories,
            'topics' => $topics,
            'socials' => $socials,
            'bannerShow' => $bannerShow,
            'contents' => $contents,
            'galleries' => $galleries,
            'sectionGallery' => $sectionGallery,
            'contact' => $contact,
            'configForm' => !is_array($configForm) ? $configForm : null,
            'cropSetting' => getCropImage('Units', 'UNIT03')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Units\UNIT03Units  $UNIT03Units
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UNIT03Units $UNIT03Units)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active ? 1 : 0;
        $data['slug'] = Str::slug($data['title']);

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null, 100);
        if ($path_image) {
            storageDelete($UNIT03Units, 'path_image');
            $data['path_image'] = $path_image;
        }
        if ($request->delete_path_image && !$path_image) {
            storageDelete($UNIT03Units, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null, 100);
        if ($path_image_icon) {
            storageDelete($UNIT03Units, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if ($request->delete_path_image_icon && !$path_image_icon) {
            storageDelete($UNIT03Units, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        $path_image_icon_show = $helper->optimizeImage($request, 'path_image_icon_show', $this->path, null, 100);
        if ($path_image_icon_show) {
            storageDelete($UNIT03Units, 'path_image_icon_show');
            $data['path_image_icon_show'] = $path_image_icon_show;
        }
        if ($request->delete_path_image_icon_show && !$path_image_icon_show) {
            storageDelete($UNIT03Units, 'path_image_icon_show');
            $data['path_image_icon_show'] = null;
        }

        $path_image_gallery = $helper->optimizeImage($request, 'path_image_gallery', $this->path, null, 100);
        if ($path_image_gallery) {
            storageDelete($UNIT03Units, 'path_image_gallery');
            $data['path_image_gallery'] = $path_image_gallery;
        }
        if ($request->delete_path_image_gallery && !$path_image_gallery) {
            storageDelete($UNIT03Units, 'path_image_gallery');
            $data['path_image_gallery'] = null;
        }

        if ($UNIT03Units->fill($data)->save()) {
            Session::flash('success', 'Unidade atualizada com sucesso');
        } else {
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
            Storage::delete($path_image_icon_show);
            Storage::delete($path_image_gallery);
            Session::flash('error', 'Erro ao atualizar a unidade');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Units\UNIT03Units  $UNIT03Units
     * @return \Illuminate\Http\Response
     */
    public function destroy(UNIT03Units $UNIT03Units)
    {
        $topics = UNIT03UnitsTopic::where('unit_id', $UNIT03Units->id)->get();
        foreach ($topics as $topic) {
            storageDelete($topic, 'path_image_icon');
            $topic->delete();
        }

        $socials = UNIT03UnitsSocial::where('unit_id', $UNIT03Units->id)->get();
        foreach ($socials as $social) {
            storageDelete($social, 'path_image_icon');
            $social->delete();
        }

        $banners = UNIT03UnitsBannerShow::where('unit_id', $UNIT03Units->id)->get();
        foreach ($banners as $banner) {
            storageDelete($banner, 'path_image_desktop');
            storageDelete($banner, 'path_image_mobile');
            $banner->delete();
        }

        $contents = UNIT03UnitsContent::where('unit_id', $UNIT03Units->id)->get();
        foreach ($contents as $content) {
            storageDelete($content, 'path_image');
            storageDelete($content, 'path_image_mobile');
            storageDelete($content, 'path_image_desktop');
            $content->delete();
        }

        $galleries = UNIT03UnitsGallery::where('unit_id', $UNIT03Units->id)->get();
        foreach ($galleries as $gallery) {
            storageDelete($gallery, 'path_image');
            $gallery->delete();
        }

        storageDelete($UNIT03Units, 'path_image');
        storageDelete($UNIT03Units, 'path_image_icon');
        storageDelete($UNIT03Units, 'path_image_icon_show');
        storageDelete($UNIT03Units, 'path_image_gallery');

        if ($UNIT03Units->delete()) {
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

        $UNIT03Unitss = UNIT03Units::whereIn('id', $request->deleteAll)->get();
        foreach ($UNIT03Unitss as $UNIT03Units) {

            $topics = UNIT03UnitsTopic::where('unit_id', $UNIT03Units->id)->get();
            foreach ($topics as $topic) {
                storageDelete($topic, 'path_image_icon');
                $topic->delete();
            }

            $socials = UNIT03UnitsSocial::where('unit_id', $UNIT03Units->id)->get();
            foreach ($socials as $social) {
                storageDelete($social, 'path_image_icon');
                $social->delete();
            }

            $banners = UNIT03UnitsBannerShow::where('unit_id', $UNIT03Units->id)->get();
            foreach ($banners as $banner) {
                storageDelete($banner, 'path_image_desktop');
                storageDelete($banner, 'path_image_mobile');
                $banner->delete();
            }

            $contents = UNIT03UnitsContent::where('unit_id', $UNIT03Units->id)->get();
            foreach ($contents as $content) {
                storageDelete($content, 'path_image');
                storageDelete($content, 'path_image_mobile');
                storageDelete($content, 'path_image_desktop');
                $content->delete();
            }

            $galleries = UNIT03UnitsGallery::where('unit_id', $UNIT03Units->id)->get();
            foreach ($galleries as $gallery) {
                storageDelete($gallery, 'path_image');
                $gallery->delete();
            }

            storageDelete($UNIT03Units, 'path_image');
            storageDelete($UNIT03Units, 'path_image_icon');
            storageDelete($UNIT03Units, 'path_image_icon_show');
            storageDelete($UNIT03Units, 'path_image_gallery');
        }

        if ($deleted = UNIT03Units::whereIn('id', $request->deleteAll)->delete()) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' unidades deletados com sucessso']);
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
            UNIT03Units::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }

    // METHODS CLIENT

    /**
     * Display the specified resource.
     * Content method
     *
     * @param  \App\Models\Units\UNIT03Units  $UNIT03Units
     * @return \Illuminate\Http\Response
     */
    //public function show(UNIT03Units $UNIT03Units)
    public function show($UNIT03UnitsCategory, UNIT03Units $UNIT03Units)
    {
        // dd($UNIT03Units);

        switch (deviceDetect()) {
            case 'mobile':
            case 'tablet':
                $bannerShow = UNIT03UnitsBannerShow::where('unit_id', $UNIT03Units->id)->active()->first();
                if ($bannerShow) {
                    $bannerShow->path_image_desktop = $bannerShow->path_image_mobile;
                }
                break;
            default:
                $bannerShow = UNIT03UnitsBannerShow::where('unit_id', $UNIT03Units->id)->active()->first();
                break;
        }

        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Units', 'UNIT03', 'show');

        $socials = UNIT03UnitsSocial::where('unit_id', $UNIT03Units->id)->active()->sorting()->get();
        $topics = UNIT03UnitsTopic::where('unit_id', $UNIT03Units->id)->active()->sorting()->get();
        $contents = UNIT03UnitsContent::with('galleryContents')->where('unit_id', $UNIT03Units->id)->active()->sorting()->get();
        $galleries = UNIT03UnitsGallery::where('unit_id', $UNIT03Units->id)->sorting()->get();
        $sectionGallery = UNIT03UnitsSectionGallery::where('unit_id', $UNIT03Units->id)->active()->first();
        $contact = UNIT03UnitsContact::where('unit_id', $UNIT03Units->id)->active()->first();

        return view('Client.pages.Units.UNIT03.show', [
            'sections' => $sections,
            'bannerShow' => $bannerShow,
            'socials' => $socials,
            'topics' => $topics,
            'contents' => $contents,
            'galleries' => $galleries,
            'unit' => $UNIT03Units,
            'contact' => $contact,
            'inputs' => $contact ? (json_decode($contact->inputs_form) ?? []) : [],
            'sectionGallery' => $sectionGallery,
        ]);
    }

    /**
     * Display a listing of the resourcee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function page(Request $request, UNIT03UnitsCategory $UNIT03UnitsCategory)
    {
        switch (deviceDetect()) {
            case 'mobile':
            case 'tablet':
                $banner = UNIT03UnitsBanner::active()->first();
                if ($banner) $banner->path_image_desktop = $banner->path_image_mobile;
                break;
            default:
                $banner = UNIT03UnitsBanner::active()->first();
                break;
        }

        $IncludeSectionsController = new IncludeSectionsController();
        $sections = $IncludeSectionsController->IncludeSectionsPage('Units', 'UNIT03', 'page');

        $categories = UNIT03UnitsCategory::active()->exists()->sorting()->get();
        $units = UNIT03Units::with('category')->active();

        if ($UNIT03UnitsCategory->exists) {
            $units = $units->where('category_id', $UNIT03UnitsCategory->id);
            foreach ($categories as $category) {
                if ($UNIT03UnitsCategory->id == $category->id) {
                    $category->selected = true;
                }
            }
        }

        $units = $units->sorting()->get();

        return view('Client.pages.Units.UNIT03.page', [
            'sections' => $sections,
            'banner' => $banner,
            'categories' => $categories,
            'units' => $units
        ]);
    }
}
