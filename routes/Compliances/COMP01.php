<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Compliances\COMP01ArchiveController;
use App\Http\Controllers\Compliances\COMP01SectionController;

// ADMIN
Route::prefix('painel')->middleware('auth')->group(function (){
    Route::resource('/compliances/sections', COMP01SectionController::class)->names('admin.comp01.section')->parameters(['sections' => 'COMP01CompliancesSection']);
    Route::post('/compliances/sections/delete', [COMP01SectionController::class, 'destroySelected'])->name('admin.comp01.section.destroySelected');
    Route::post('/compliances/sections/sorting', [COMP01SectionController::class, 'sorting'])->name('admin.comp01.section.sorting');

    Route::resource('/compliances/arquivos', COMP01ArchiveController::class)->names('admin.comp01.archive')->parameters(['arquivos' => 'COMP01CompliancesArchive']);
    Route::post('/compliances/arquivos/delete', [COMP01ArchiveController::class, 'destroySelected'])->name('admin.comp01.archive.destroySelected');
    Route::post('/compliances/arquivos/sorting', [COMP01ArchiveController::class, 'sorting'])->name('admin.comp01.archive.sorting');
});
