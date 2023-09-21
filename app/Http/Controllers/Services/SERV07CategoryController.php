<?php

namespace App\Http\Controllers\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Services\SERV07Services;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Services\SERV07ServicesVideo;
use App\Http\Controllers\Helpers\HelperArchive;
use App\Models\Services\SERV07ServicesCategory;
use App\Http\Controllers\IncludeSectionsController;
use App\Models\Services\SERV07ServicesTopicCategory;
use App\Models\Services\SERV07ServicesGalleryCategory;
use App\Models\Services\SERV07ServicesSectionCategory;

class SERV07CategoryController extends Controller
{
    protected $path = 'uploads/Services/SERV07/images/';

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Admin.cruds.Services.SERV07.Category.create",[
            'cropSetting' => getCropImage('Services', 'SERV07')
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

        $data['active'] = $request->active?1:0;
        $data['featured'] = $request->featured?1:0;
        $data['slug'] = Str::slug($request->title);
        $data['link_button'] = isset($data['link_button']) ?getUri($data['link_button']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image) $data['path_image'] = $path_image;

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon) $data['path_image_icon'] = $path_image_icon;

        //Banner Show
        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null,100);
        if($path_image_desktop) $data['path_image_desktop'] = $path_image_desktop;

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null,100);
        if($path_image_mobile) $data['path_image_mobile'] = $path_image_mobile;

        if($category = SERV07ServicesCategory::create($data)){
            Session::flash('success', 'Categoria cadastrada com sucesso');
            return redirect()->route('admin.serv07.category.edit', ['SERV07ServicesCategory' => $category->id]);
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao cadastradar a categoria');
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Services\SERV07ServicesCategory  $SERV07ServicesCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(SERV07ServicesCategory $SERV07ServicesCategory)
    {
        $sectionsCategory = SERV07ServicesSectionCategory::where('category_id', $SERV07ServicesCategory->id)->sorting()->get();
        $videos = SERV07ServicesVideo::where('category_id', $SERV07ServicesCategory->id)->sorting()->get();
        $galleriesCategory = SERV07ServicesGalleryCategory::where('category_id', $SERV07ServicesCategory->id)->sorting()->get();
        $topicsCategory = SERV07ServicesTopicCategory::where('category_id', $SERV07ServicesCategory->id)->sorting()->get();
        return view("Admin.cruds.Services.SERV07.Category.edit",[
            'category' => $SERV07ServicesCategory,
            'sectionsCategory' => $sectionsCategory,
            'videos' => $videos,
            'galleriesCategory' => $galleriesCategory,
            'topicsCategory' => $topicsCategory,
            'cropSetting' => getCropImage('Services', 'SERV07')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services\SERV07ServicesCategory  $SERV07ServicesCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SERV07ServicesCategory $SERV07ServicesCategory)
    {
        $data = $request->all();
        $helper = new HelperArchive();

        $data['active'] = $request->active?1:0;
        $data['featured'] = $request->featured?1:0;
        $data['slug'] = Str::slug($request->title);
        $data['link_button'] = isset($data['link_button']) ?getUri($data['link_button']) : null;

        $path_image = $helper->optimizeImage($request, 'path_image', $this->path, null,100);
        if($path_image){
            storageDelete($SERV07ServicesCategory, 'path_image');
            $data['path_image'] = $path_image;
        }
        if($request->delete_path_image && !$path_image){
            storageDelete($SERV07ServicesCategory, 'path_image');
            $data['path_image'] = null;
        }

        $path_image_icon = $helper->optimizeImage($request, 'path_image_icon', $this->path, null,100);
        if($path_image_icon){
            storageDelete($SERV07ServicesCategory, 'path_image_icon');
            $data['path_image_icon'] = $path_image_icon;
        }
        if($request->delete_path_image_icon && !$path_image_icon){
            storageDelete($SERV07ServicesCategory, 'path_image_icon');
            $data['path_image_icon'] = null;
        }

        //Banner Show
        $path_image_desktop = $helper->optimizeImage($request, 'path_image_desktop', $this->path, null,100);
        if($path_image_desktop){
            storageDelete($SERV07ServicesCategory, 'path_image_desktop');
            $data['path_image_desktop'] = $path_image_desktop;
        }
        if($request->delete_path_image_desktop && !$path_image_desktop){
            storageDelete($SERV07ServicesCategory, 'path_image_desktop');
            $data['path_image_desktop'] = null;
        }

        $path_image_mobile = $helper->optimizeImage($request, 'path_image_mobile', $this->path, null,100);
        if($path_image_mobile){
            storageDelete($SERV07ServicesCategory, 'path_image_mobile');
            $data['path_image_mobile'] = $path_image_mobile;
        }
        if($request->delete_path_image_mobile && !$path_image_mobile){
            storageDelete($SERV07ServicesCategory, 'path_image_mobile');
            $data['path_image_mobile'] = null;
        }

        if($SERV07ServicesCategory->fill($data)->save()){
            Session::flash('success', 'Categoria atualizada com sucesso');
        }else{
            Storage::delete($path_image);
            Storage::delete($path_image_icon);
            Storage::delete($path_image_desktop);
            Storage::delete($path_image_mobile);
            Session::flash('error', 'Erro ao atualizar a categoria');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services\SERV07ServicesCategory  $SERV07ServicesCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SERV07ServicesCategory $SERV07ServicesCategory)
    {
        // Verificar se existem serviços associadas à categoria
        if (SERV07Services::where('category_id', $SERV07ServicesCategory->id)->count()) {
            Session::flash('error', 'Não é possível excluir a categoria porque existem serviços associadas a ela.');
            return redirect()->back();
        }

        $sections = SERV07ServicesSectionCategory::where('category_id', $SERV07ServicesCategory->id)->get();
        if ($sections){
            foreach ($sections as $section){
                storageDelete($section, 'path_image');
                $section->delete();
            }
        }

        $videos = SERV07ServicesVideo::where('category_id', $SERV07ServicesCategory->id)->get();
        if ($videos){
            foreach ($videos as $video){
                storageDelete($video, 'path_image');
                $video->delete();
            }
        }

        $galleries = SERV07ServicesGalleryCategory::where('category_id', $SERV07ServicesCategory->id)->get();
        if ($galleries){
            foreach ($galleries as $gallery){
                storageDelete($gallery, 'path_image');
                $gallery->delete();
            }
        }

        $topics = SERV07ServicesTopicCategory::where('category_id', $SERV07ServicesCategory->id)->get();
        if ($topics){
            foreach ($topics as $topic){
                storageDelete($topic, 'path_image');
                storageDelete($topic, 'path_image_icon');
                $topic->delete();
            }
        }

        // Excluir a categoria
        storageDelete($SERV07ServicesCategory, 'path_image');
        storageDelete($SERV07ServicesCategory, 'path_image_icon');
        storageDelete($SERV07ServicesCategory, 'path_image_desktop');
        storageDelete($SERV07ServicesCategory, 'path_image_mobile');

        if($SERV07ServicesCategory->delete()){
            Session::flash('success', 'categoria deletado com sucessso');
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
        $categoryIds = $request->deleteAll;

        // Verificar se existem serviços associadas às categorias
        $serviceExist = SERV07Services::whereIn('category_id', $categoryIds)->exists();
        if ($serviceExist) {
            return Response::json([
                'status' => 'error',
                'message' => 'Não é possível excluir as categorias porque existem serviços associadas a elas.'
            ]);
        }

        // Excluir as categorias
        $deletedCategories = SERV07ServicesCategory::whereIn('id', $categoryIds)->get();
        foreach ($deletedCategories as $category) {
            $sections = SERV07ServicesSectionCategory::where('category_id', $category->id)->get();
            if ($sections){
                foreach ($sections as $section){
                    storageDelete($section, 'path_image');
                    $section->delete();
                }
            }

            $videos = SERV07ServicesVideo::where('category_id', $category->id)->get();
            if ($videos){
                foreach ($videos as $video){
                    storageDelete($video, 'path_image');
                    $video->delete();
                }
            }

            $galleries = SERV07ServicesGalleryCategory::where('category_id', $category->id)->get();
            if ($galleries){
                foreach ($galleries as $gallery){
                    storageDelete($gallery, 'path_image');
                    $gallery->delete();
                }
            }

            $topics = SERV07ServicesTopicCategory::where('category_id', $category->id)->get();
            if ($topics){
                foreach ($topics as $topic){
                    storageDelete($topic, 'path_image');
                    storageDelete($topic, 'path_image_icon');
                    $topic->delete();
                }
            }

            storageDelete($category, 'path_image_icon');
            storageDelete($category, 'path_image_desktop');
            storageDelete($category, 'path_image_mobile');
            storageDelete($category, 'path_image');
        }

        if ($deleted = SERV07ServicesCategory::whereIn('id', $categoryIds)->delete()) {
            return Response::json(['status' => 'success','message' => $deleted . ' categorias deletadas com sucesso']);
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
            SERV07ServicesCategory::where('id', $id)->update(['sorting' => $sorting]);
        }
        return Response::json(['status' => 'success']);
    }
}
