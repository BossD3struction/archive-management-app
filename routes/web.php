<?php

use App\Http\Controllers\CarsController;
use App\Http\Controllers\FilesController;
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

Route::get('/', [FilesController::class, 'routeToIndexPage']);

Route::get('/found/files', function () {
    return redirect('/');
});

Route::post('/found/files', [FilesController::class, 'findFilesInDirectory']);

Route::get('/upload/files', function () {
    return redirect('/');
});

Route::post('/upload/files', [FilesController::class, 'uploadFoundFilesIntoDatabase']);
