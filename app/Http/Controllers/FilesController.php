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
        } catch (Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
        return view('files.found', [
            'files' => $files
        ]);
    }

    public function uploadFoundFilesIntoDatabase(Request $request)
    {
        // Debug code
        /*$filesPaths = $request->input('found_files');
        foreach ($filesPaths as $filePath) {
            $getID3 = new getID3;
            $fileInfo = $getID3->analyze($filePath);
            if (Mp3File::where('filename_path', $fileInfo['filenamepath'])->doesntExist()) {
                Mp3File::create([
                    'filename_path' => $fileInfo['filenamepath'],
                    'filename' => $fileInfo['filename'],
                    'title' => $fileInfo['tags']['id3v2']['title'][0] ?? '',
                    'artist' => $fileInfo['tags']['id3v2']['artist'][0] ?? '',
                    'album' => $fileInfo['tags']['id3v2']['album'][0] ?? ''
                ]);
            } else {
                var_dump($fileInfo['filenamepath'] . 'is already in DB');
            }
        }*/

        $filesPaths = $request->input('found_files');
        foreach ($filesPaths as $filePath) {
            $getID3 = new getID3;
            $fileInfo = $getID3->analyze($filePath);
            if (Mp3File::where('filename_path', $fileInfo['filenamepath'])->doesntExist()) {
                Mp3File::create([
                    'filename_path' => $fileInfo['filenamepath'],
                    'filename' => $fileInfo['filename'],
                    'title' => $fileInfo['tags']['id3v2']['title'][0] ?? '',
                    'artist' => $fileInfo['tags']['id3v2']['artist'][0] ?? '',
                    'album' => $fileInfo['tags']['id3v2']['album'][0] ?? ''
                ]);
            }
        }

        return redirect('/files');
    }

    public function routeToIndexPage()
    {
        return view('files.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('files.files');
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
