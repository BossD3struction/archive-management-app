<?php
/** @noinspection PhpUndefinedMethodInspection */

namespace App\Http\Controllers;

use App\Models\Mp3File;
use Exception;
use getID3;
use Illuminate\Http\Request;
use Symfony\Component\Finder\Finder;

class FilesController extends Controller
{
    // looks for mp3 | jpg files
    public function findAllSpecifiedFilesInDirectory(Request $request)
    {
        $request->validate(['directory' => 'required']);
        $directory = $request->input('directory');
        try {
            $foundFiles = Finder::create()
                ->in($directory)
                ->ignoreUnreadableDirs()
                ->name(['*.jpg', '*.mp3']);
        } catch (Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
        $foundFiles->hasResults() ? $isEmpty = false : $isEmpty = true;
        return view('files.found', ['foundFiles' => $foundFiles, 'isEmpty' => $isEmpty]);
    }

    // looks for mp3 files
    /*public function findMp3FilesInDirectory(Request $request)
    {
        $request->validate(['directory' => 'required']);
        $directory = $request->input('directory');
        try {
            $foundFiles = Finder::create()
                ->in($directory)
                ->ignoreUnreadableDirs()
                ->name(['*.mp3']);
        } catch (Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }

        $foundFiles->hasResults() ? $isEmpty = false : $isEmpty = true;
        return view('files.found', ['foundFiles' => $foundFiles, 'isEmpty' => $isEmpty]);
    }*/

    public function uploadFoundFilesIntoDatabase(Request $request)
    {
        $getID3 = new getID3;
        $foundFiles = $request->input('found_files');
        foreach ($foundFiles as $filenamePath) {
            if (Mp3File::where('filename_path', $filenamePath)->doesntExist()) {
                $fileMetadata = $getID3->analyze($filenamePath);
                Mp3File::create([
                    'filename_path' => $filenamePath,
                    'filename' => $fileMetadata['filename'],
                    'title' => $fileMetadata['tags']['id3v2']['title'][0] ?? '',
                    'artist' => $fileMetadata['tags']['id3v2']['artist'][0] ?? '',
                    'album' => $fileMetadata['tags']['id3v2']['album'][0] ?? '',
                    'genre' => $fileMetadata['tags']['id3v2']['genre'][0] ?? '',
                    'year' => $fileMetadata['tags']['id3v2']['year'][0] ?? ''
                ]);
            }
        }
        return redirect('/files');
    }

    public function routeToFilesIndexPage()
    {
        return view('files.index');
    }
}
