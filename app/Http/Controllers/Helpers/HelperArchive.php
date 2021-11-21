<?php

namespace App\Http\Controllers\Helpers;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

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
     * Rename file for uploads
     *
     * @param Illuminate\Http\Request $request
     * @param string $column
     *
     * @return string|boolean
     */
    public function renameArchiveUpload($request, $column)
    {
        $columnCrop = $column.'_cropped';
        if($request->has($columnCrop) && strpos($request->$columnCrop, ';base64')){
            //Get image base64
            $fileBase64 = explode(',', $request->$columnCrop)[1];
            // Rename file
            $nameFile = $request->$column->getClientOriginalName();
            $originalName = Str::of(pathinfo($nameFile, PATHINFO_FILENAME))->slug().'-'.time();
            $arrayName = explode('.', $nameFile);
            $extension = end($arrayName);
            $nameFile = "{$originalName}.{$extension}";

            return [$fileBase64, $nameFile];
        }

        if ($request->hasFile($column)) {
            if(is_array($request->$column)){
                $arrNameFile = [];
                foreach ($request->$column as $key => $value) {
                    $nameFile = $request->$column[$key]->getClientOriginalName();
                    $originalName = Str::of(pathinfo($nameFile, PATHINFO_FILENAME))->slug().'-'.time();
                    $arrayName = explode('.', $nameFile);
                    $extension = end($arrayName);
                    array_push($arrNameFile, "{$originalName}.{$extension}");
                    $nameFile = $arrNameFile;
                }
            }else{
                $nameFile = $request->$column->getClientOriginalName();
                $originalName = Str::of(pathinfo($nameFile, PATHINFO_FILENAME))->slug().'-'.time();
                $arrayName = explode('.', $nameFile);
                $extension = end($arrayName);
                $nameFile = "{$originalName}.{$extension}";
            }

            return $nameFile;
        }else{
            return false;
        }
    }
}
