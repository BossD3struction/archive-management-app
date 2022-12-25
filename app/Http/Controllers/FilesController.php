<?php

namespace App\Http\Controllers;

use App\Models\JpgFile;
use App\Models\Mp3File;
use Exception;
use getID3;
use Illuminate\Http\Request;
use lsolesen\pel\PelException;
use lsolesen\pel\PelIfd;
use lsolesen\pel\PelJpeg;
use lsolesen\pel\PelTag;
use Symfony\Component\Finder\Finder;

class FilesController extends Controller
{
    public function findAllSpecifiedFilesInDirectory(Request $request)
    {
        ini_set('max_execution_time', 60);
        ini_set('memory_limit', '4096M');
        $request->validate(['directory' => 'required']);
        $directory = $request->input('directory');

        try {
            $foundFiles = Finder::create()
                ->in($directory)
                ->ignoreUnreadableDirs()
                ->name(['*.jpg', '*.mp3']);
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }

        $foundFiles->hasResults() ? $isEmpty = false : $isEmpty = true;
        if (sizeof($foundFiles) === 1) flash()->addInfo(sizeof($foundFiles) . ' file found');
        if (sizeof($foundFiles) > 1) flash()->addInfo(sizeof($foundFiles) . ' files found');
        return view('files.found', ['foundFiles' => $foundFiles, 'isEmpty' => $isEmpty]);
    }

    /**
     * @throws PelException
     */
    public function uploadFoundFilesIntoDatabase(Request $request)
    {
        ini_set('max_execution_time', 120);
        ini_set('memory_limit', '4096M');
        $foundFiles = $request->input('found_files');
        $recordsCount = Mp3File::count();
        $recordsCount += JpgFile::count();
        $newUploadsCount = 0;

        $newUploadsCount = $this->uploadFilesAndGetNewUploadsCount($foundFiles, $newUploadsCount);

        $recordsCount === 1 ?
            $request->session()->flash('info', $recordsCount . ' file in database') :
            $request->session()->flash('info', $recordsCount . ' files in database');
        $newUploadsCount === 1 ?
            $request->session()->flash('success', $newUploadsCount . ' file uploaded into database') :
            $request->session()->flash('success', $newUploadsCount . ' files uploaded into database');

        return redirect('/files');
    }

    /**
     * @throws PelException
     */
    public function uploadFilesAndGetNewUploadsCount($foundFiles, int $newUploadsCount): int
    {
        foreach ($foundFiles as $filenamePath) {
            $getID3 = new getID3;
            $pelJpeg = new PelJpeg;
            $fileExtension = pathinfo($filenamePath, PATHINFO_EXTENSION);
            if ($fileExtension === 'mp3') {
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
                    $newUploadsCount++;
                }
            } elseif ($fileExtension === 'jpg') {
                if (JpgFile::where('filename_path', $filenamePath)->doesntExist()) {
                    $pelJpeg->loadFile($filenamePath);
                    $fileMetadata = $getID3->analyze($filenamePath);
                    list($xpTitle, $xpKeyword, $xpComment, $dateTimeOriginal, $hasExifMetadata) =
                        $this->getJpgFileMetadataValues($fileMetadata, $pelJpeg);
                    JpgFile::create([
                        'filename_path' => $filenamePath,
                        'filename' => $fileMetadata['filename'],
                        'title' => $xpTitle,
                        'tags' => $xpKeyword,
                        'comments' => $xpComment,
                        'date' => $dateTimeOriginal,
                        'has_exif_metadata' => $hasExifMetadata,
                    ]);
                    $newUploadsCount++;
                }
            }
        }
        return $newUploadsCount;
    }

    private function getJpgFileMetadataValues($fileMetadata, $pelJpeg)
    {
        $exif = $pelJpeg->getExif();
        $hasExifMetadata = false;
        $xpTitle = '';
        $xpKeyword = '';
        $xpComment = '';
        $dateTimeOriginal = '';

        if (!is_null($exif)) {
            $ifd0 = $exif->getTiff()->getIfd();
            $hasExifMetadata = true;
            $xpTitle = $this->getXpTitleValue($ifd0);
            $xpKeyword = $this->getXpKeywordValue($ifd0);
            $xpComment = $this->getXpCommentValue($ifd0);
            if (array_key_exists("EXIF", $fileMetadata['jpg']['exif'])) {
                $date = date("d/m/Y", strtotime($fileMetadata['jpg']['exif']['EXIF']['DateTimeOriginal']));
                $dateTimeOriginal = $date;
            }
        }

        return array($xpTitle, $xpKeyword, $xpComment, $dateTimeOriginal, $hasExifMetadata);
    }

    private function getXpTitleValue(?PelIfd $ifd0)
    {
        $entry = $ifd0->getEntry(PelTag::XP_TITLE);
        if (!is_null($entry)) {
            return $entry->getValue();
        } else {
            return '';
        }
    }

    private function getXpKeywordValue(?PelIfd $ifd0)
    {
        $entry = $ifd0->getEntry(PelTag::XP_KEYWORDS);
        if (!is_null($entry)) {
            return $entry->getValue();
        } else {
            return '';
        }
    }

    private function getXpCommentValue(?PelIfd $ifd0)
    {
        $entry = $ifd0->getEntry(PelTag::XP_COMMENT);
        if (!is_null($entry)) {
            return $entry->getValue();
        } else {
            return '';
        }
    }

    public function routeToFilesIndexPage()
    {
        return view('files.index');
    }
}
