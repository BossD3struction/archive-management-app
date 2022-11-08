<?php

use App\Http\Controllers\CarsController;
use App\Http\Controllers\FilesController;
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

Route::resource('/cars', CarsController::class);

Route::resource('/files', FilesController::class);

Route::resource('/files/mp3', Mp3FilesController::class);

Route::get('/mp3/table', [Mp3FilesController::class, 'renderMp3FilesTable']);

//Route::get('/', [FilesController::class, 'routeToIndexPage']);

Route::post('/found/files', [FilesController::class, 'findMp3FilesInDirectory']);

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
