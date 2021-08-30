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
        if ($request->hasFile($column) && $request->file($column)->isValid()) {
            $extension = $request->$column->extension();
            $originalName = Str::of(pathinfo($request->$column->getClientOriginalName(), PATHINFO_FILENAME))->slug().'-'.time();
            $nameFile = "{$originalName}.{$extension}";
            return $nameFile;
        }else{
            return false;
        }
    }
}
