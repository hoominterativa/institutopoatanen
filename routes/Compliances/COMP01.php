<?php

use App\Http\Controllers\Compliances\COMP01ArchiveController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function (){
    Route::resource('/compliances/arquivos', COMP01ArchiveController::class)->names('admin.comp01.archive')->parameters(['arquivos' => 'COMP01CompliancesArchive']);
    Route::post('/compliances/arquivos/delete', [COMP01ArchiveController::class, 'destroySelected'])->name('admin.comp01.archive.destroySelected');
    Route::post('/compliances/arquivos/sorting', [COMP01ArchiveController::class, 'sorting'])->name('admin.comp01.archive.sorting');
});
