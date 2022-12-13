<?php

namespace App\Http\Controllers\Helpers;

use Gumlet\ImageResize;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class HelperArchive extends Controller
{
    /**
     * @param string $nameArchive path with file name and extension
     * Note: Initial Root Path
     * @param string $content content to be printed on file
     *
     * @return Boolean
     */
    public function createArchive($nameArchive, $content)
    {
        $archive = fopen(''.$nameArchive,'w');
        if ($archive == false) die('Não foi possível criar o arquivo.');
        if(fwrite($archive, $content)){
            fclose($archive);
            return true;
        }
        return false;
    }

    /**
     * Upload archives
     *
     * @param Illuminate\Http\Request $request
     * @param string $column
     *
     * @return object
     */
    public function uploadArchive($request, $column, $path)
    {
        if ($request->hasFile($column)) {
            $nameFile = $request->$column->getClientOriginalName();
            $name = Str::of(pathinfo($nameFile, PATHINFO_FILENAME))->slug().'-'.time().'.'.$request->$column->getClientOriginalExtension();
            $request->$column->storeAs($path, $name);
            return $path.$name;
        }else{
            return false;
        }
    }

    /**
     * Upload Multiple images
     *
     * @param Illuminate\Http\Request $request
     * @param string $column
     *
     * @return object
     */
    public function uploadMultipleImage($request, $column, $path, $width=null, $quality=null)
    {
        if ($request->hasFile($column)) {
            $namesReturn = [];
            foreach ($request->$column as $file) {
                // Max width of image
                $sizeBase = 2000;

                // Protection from image clone
                !Session::has('timestampArchive')?Session::put('timestampArchive', 1):Session::put('timestampArchive', Session::get('timestampArchive')+1);
                $timestampArchive = Session::get('timestampArchive');

                // Create path if not exist
                if(!is_dir(storage_path('app/public/'.$path))) mkdir(storage_path('app/public/'.$path), 0777, true);

                // Image name slug
                $name = Str::of(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))->slug().'-'. (time()+$timestampArchive);

                // Destination the image save
                $destinationPath = storage_path('app/public/'.$path);

                $fileImage = $file->getRealPath();
                $image = new ImageResize($fileImage);
                $widthImage = $image->getDestWidth();

                if($width){
                    // Resize image as of width
                    $image->resizeToWidth($width);
                }else{
                    // Resize image as of scale
                    if($widthImage > $sizeBase){
                        $image->scale(80);
                    }else{
                        $image->scale(100);
                    }
                }

                // Save image optimized
                $image->save($destinationPath.$name.'.webp', IMAGETYPE_WEBP, $quality);

                // Ensures the image has been optimized
                $optimizedImage = new ImageResize($destinationPath.$name.'.webp');
                $currentWidth = $optimizedImage->getDestWidth();
                if($currentWidth > $sizeBase){
                    for ($size=$currentWidth; $size > $sizeBase;) {
                        $optimizedImage = new ImageResize($destinationPath.$name.'.webp');
                        $optimizedImage->scale(70)->save($destinationPath.$name.'.webp', IMAGETYPE_WEBP);
                        $optimizedImageCurrent = new ImageResize($destinationPath.$name.'.webp');
                        $size = $optimizedImageCurrent->getDestWidth();
                    }
                }

                $nameFinised = $path.$name.'.webp';
                $namesReturn = array_merge($namesReturn, [$nameFinised]);
            }

            return $namesReturn;

        }else{
            return false;
        }
    }

    /**
     * Upload images at not resize
     *
     * @param Illuminate\Http\Request $request
     * @param string $column
     *
     * @return object
     */
    public function uploadImage($request, $column, $path)
    {
        $nameCurrent =  pathinfo($request->$column->getClientOriginalName(), PATHINFO_FILENAME);
        $extension =  $request->$column->getClientOriginalExtension();
        $name = Str::of($nameCurrent)->slug().'-'.time().'.'.$extension;
        $request->$column->storeAs($path, $name);
        return $path.$name;
    }

    /**
     * Optimize and save image
     *
     * @param \Illuminate\Http\Request $request
     * @param string $column Post field
     * @param string $path Image path to save
     * @param integer $width Max width resize image
     * @param integer $quality Quality the image
     *
     * @return string|bool False if no image form loaded and image path after optimization
     */

    public function optimizeImage($request, $column, $path, $width=null, $quality=null)
    {
        if ($request->hasFile($column)) {
            $mimeTypeAcept = ['image/svg','image/svg+xml'];
            if(array_search($request->$column->getMimeType(), $mimeTypeAcept) !== false){
                $uploadImage = self::uploadImage($request, $column, $path);
                return $uploadImage;
            }

            // Max width of image
            $sizeBase = 2000;

            // Protection from image clone
            !Session::has('timestampArchive')?Session::put('timestampArchive', 1):Session::put('timestampArchive', Session::get('timestampArchive')+1);
            $timestampArchive = Session::get('timestampArchive');

            // Verify image crop
            $columnCrop = $column.'_cropped';

            if(!$request->has($columnCrop)){
                $this->validate($request, [
                    $column => 'image|mimes:jpeg,png,jpg,gif,webp',
                ],[
                    $column.'.image' => 'Formato de imagem inválido, formatos aceitos jpeg,png,jpg,gif,webp',
                    $column.'.mime' => 'Formato de imagem inválido, formatos aceitos jpeg,png,jpg,gif,webp',
                    $column.'.max' => 'Imagem grande demais, a imagem deve ser menor que 2mb'
                ],['path_image' => 'Imagem']);
            }

            // Create path if not exist
            if(!is_dir(storage_path('app/public/'.$path))) mkdir(storage_path('app/public/'.$path), 0777, true);

            // Image name slug
            $name = Str::of(pathinfo($request->$column->getClientOriginalName(), PATHINFO_FILENAME))->slug().'-'. (time()+$timestampArchive);

            // Destination the image save
            $destinationPath = storage_path('app/public/'.$path);

            // If base64 encoded image exists, convert and save image
            if($request->has($columnCrop) && strpos($request->$columnCrop, ';base64')){
                $fileBase64 = explode(',', $request->$columnCrop)[1];
                Storage::put($path.$name.'.'.$request->$column->getClientOriginalExtension(), base64_decode($fileBase64));
                $fileImage = $destinationPath.$name.'.'.$request->$column->getClientOriginalExtension();
            }else{
                $fileImage = $request->$column->getRealPath();
            }

            $image = new ImageResize($fileImage);

            $widthImage = $image->getDestWidth();

            if($width){
                // Resize image as of width
                $image->resizeToWidth($width);
            }else{
                // Resize image as of scale
                if($widthImage > $sizeBase){
                    $image->scale(80);
                }else{
                    $image->scale(100);
                }
            }

            // Save image optimized
            $image->save($destinationPath.$name.'.webp', IMAGETYPE_WEBP, $quality);

            // Ensures the image has been optimized
            $optimizedImage = new ImageResize($destinationPath.$name.'.webp');
            $currentWidth = $optimizedImage->getDestWidth();
            if($currentWidth > $sizeBase){
                for ($size=$currentWidth; $size > $sizeBase;) {
                    $optimizedImage = new ImageResize($destinationPath.$name.'.webp');
                    $optimizedImage->scale(70)->save($destinationPath.$name.'.webp', IMAGETYPE_WEBP);
                    $optimizedImageCurrent = new ImageResize($destinationPath.$name.'.webp');
                    $size = $optimizedImageCurrent->getDestWidth();
                }
            }

            // Delete image converted
            if($request->has($columnCrop)) Storage::delete($path.$name.'.'.$request->$column->getClientOriginalExtension());

            return $path.$name.'.webp';
        }else{
            return false;
        }
    }
}
