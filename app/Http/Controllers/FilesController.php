<?php /** @noinspection PhpUndefinedMethodInspection */

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
    /*public function routeToIndexPage()
    {
        return view('files.files');
    }*/

    // looks for .mp3 | .jpg | files
    public function findAllSpecifiedFilesInDirectory(Request $request)
    {
        $request->validate(['directory_path' => 'required']);
        $directory = $request->input('directory_path');
        try {
            $files = Finder::create()
                ->in($directory)
                ->ignoreUnreadableDirs()
                ->name(['*.jpg', '*.mp3']);
        } catch (Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }

        $files->hasResults() ? $isEmpty = false : $isEmpty = true;

        return view('files.found', ['files' => $files, 'isEmpty' => $isEmpty]);
    }

    // looks for .mp3 files
    public function findMp3FilesInDirectory(Request $request)
    {
        $request->validate(['directory_path' => 'required']);
        $directory = $request->input('directory_path');
        try {
            $files = Finder::create()
                ->in($directory)
                ->ignoreUnreadableDirs()
                ->name(['*.mp3']);
        } catch (Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }

        $files->hasResults() ? $isEmpty = false : $isEmpty = true;

        return view('files.found', ['files' => $files, 'isEmpty' => $isEmpty]);
    }

    public function uploadFoundFilesIntoDatabase(Request $request)
    {
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
                    'album' => $fileInfo['tags']['id3v2']['album'][0] ?? '',
                    'genre' => $fileInfo['tags']['id3v2']['genre'][0] ?? '',
                    'year' => $fileInfo['tags']['id3v2']['year'][0] ?? ''
                ]);
            }
        }

        return redirect('/files');
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
}
