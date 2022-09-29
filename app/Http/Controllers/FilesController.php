<?php
/** @noinspection PhpUndefinedMethodInspection */

namespace App\Http\Controllers;

use App\Models\Mp3File;
use Exception;
use getID3;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\Finder\Finder;

class FilesController extends Controller
{
    public function findFilesInDirectory(Request $request)
    {
        $request->validate(['directory_path' => 'required']);
        $directory = $request->input('directory_path');
        try {
            $files = Finder::create()
                ->in($directory)
                ->ignoreUnreadableDirs()
                ->name(['*.mp3']);
            //->name(['*.png', '*.jpg', '*.mp3']);
            //} catch (DirectoryNotFoundException $exception) {
        } catch (Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
        return view('files.found', [
            'files' => $files
        ]);
    }

    public function uploadFoundFilesIntoDatabase(Request $request)
    {
        $filesPaths = $request->input('found_files');
        foreach ($filesPaths as $filePath) {
            //print_r($filePath);
            $getID3 = new getID3;
            $fileInfo = $getID3->analyze($filePath);
            /*print_r("filenamepath" . $fileInfo['filenamepath']);
            print_r("\n\nfilename" . $fileInfo['filename']);
            print_r("\ntitle" . $fileInfo['tags']['id3v2']['title'][0]);
            print_r("\nartist" . $fileInfo['tags']['id3v2']['artist'][0]);
            print_r("\nalbum" . $fileInfo['tags']['id3v2']['album'][0]);*/
            Mp3File::create([
                'filename_path' => $fileInfo['filenamepath'],
                'filename' => $fileInfo['filename'],
                'title' => $fileInfo['tags']['id3v2']['title'][0],
                'artist' => $fileInfo['tags']['id3v2']['artist'][0],
                'album' => $fileInfo['tags']['id3v2']['album'][0]
            ]);
        }

        //return redirect('/files');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        /*$directory = "C:\\xampp\\htdocs\\bachelor_project\\test_files";
        $files = Finder::create()
            ->in($directory)
            ->name(['*.png', '*.jpg', '*.mp3']);
        return view('files.index', [
            'files' => $files
        ]);*/
        return view('files.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Application|Factory|View|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
