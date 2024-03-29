<?php

use App\Http\Controllers\FilesController;
use App\Http\Controllers\JpgFilesController;
use App\Http\Controllers\Mp3FilesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/files', [FilesController::class, 'routeToFilesIndexPage']);

Route::resource('/files/mp3', Mp3FilesController::class);

Route::resource('/files/jpg', JpgFilesController::class);

Route::get('/mp3/table', [Mp3FilesController::class, 'renderMp3FilesTable']);

Route::get('/jpg/table', [JpgFilesController::class, 'renderJpgFilesTable']);

Route::post('/found/files', [FilesController::class, 'findAllSpecifiedFilesInDirectory']);

Route::post('/upload/files', [FilesController::class, 'uploadFoundFilesIntoDatabase']);

Route::get('/found/files', function () {
    return redirect('/files');
});

Route::get('/upload/files', function () {
    return redirect('/files');
});

Route::get('/', function () {
    return redirect('/files');
});
