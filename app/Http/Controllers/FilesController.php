<?php
/** @noinspection PhpUnusedLocalVariableInspection */
/** @noinspection PhpUndefinedMethodInspection */

namespace App\Http\Controllers;

use App\DataTables\Mp3FileDataTable;
use App\Models\Mp3File;
use Exception;
use getID3;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Stormiix\EyeD3\EyeD3;
use Symfony\Component\Finder\Finder;

class FilesController extends Controller
{

    public function renderMp3FilesTable(Mp3FileDataTable $dataTable)
    {
        return $dataTable->render('files.table_mp3');
    }

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

    /*public function HI()
    {
        return datatables()->eloquent(Mp3File::query())->toJson();
    }*/

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
            if (Mp3File::where('filename_path', $filePath)->doesntExist()) {
                Mp3File::create([
                    'filename_path' => $filePath,
                    'filename' => $fileInfo['filename'],
                    'title' => $fileInfo['tags']['id3v2']['title'][0] ?? '',
                    'artist' => $fileInfo['tags']['id3v2']['artist'][0] ?? '',
                    'album' => $fileInfo['tags']['id3v2']['album'][0] ?? ''
                ]);
            }
            /*if (Mp3File::where('filename_path', $fileInfo['filenamepath'])->doesntExist()) {
                Mp3File::create([
                    'filename_path' => $fileInfo['filenamepath'],
                    'filename' => $fileInfo['filename'],
                    'title' => $fileInfo['tags']['id3v2']['title'][0] ?? '',
                    'artist' => $fileInfo['tags']['id3v2']['artist'][0] ?? '',
                    'album' => $fileInfo['tags']['id3v2']['album'][0] ?? ''
                ]);
            }*/
        }

        return redirect('/files');
    }

    public function routeToIndexPage()
    {
        return view('files.index');
    }

    private function updateMp3MetaData($filename, $title, $artist, $album)
    {
        $eyed3 = new EyeD3($filename);

        $meta = [
            "title" => $title,
            "artist" => $artist,
            "album" => $album
        ];

        $eyed3->updateMeta($meta);
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
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|Factory|View|Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(int $id)
    {
        $file = Mp3File::find($id);
        return view('files.edit')->with('file', $file);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Application|Redirector|RedirectResponse
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'title' => 'required',
            'artist' => 'required',
            'album' => 'required'
        ]);

        $filename_path = $request->input('filename_path');
        $title = $request->input('title');
        $artist = $request->input('artist');
        $album = $request->input('album');

        $file = Mp3File::where('id', $id)
            ->update([
                'title' => $title,
                'artist' => $artist,
                'album' => $album
            ]);

        $this->updateMp3MetaData($filename_path, $title, $artist, $album);
        return redirect('/table/mp3');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|Redirector|RedirectResponse
     */
    public function destroy(int $id)
    {
        $file = Mp3File::find($id);
        $file->delete();
        return redirect('/table/mp3');
    }
}
