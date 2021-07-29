<?php

namespace App\Http\Controllers\Helpers;

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
}
