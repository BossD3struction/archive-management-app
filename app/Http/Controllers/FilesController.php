<?php

namespace App\Http\Controllers;

use App\Models\JpgFile;
use App\Models\Mp3File;
use Exception;
use getID3;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use lsolesen\pel\PelIfd;
use lsolesen\pel\PelInvalidArgumentException;
use lsolesen\pel\PelJpeg;
use lsolesen\pel\PelTag;
use Symfony\Component\Finder\Finder;

class FilesController extends Controller
{
    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
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

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     * @throws PelInvalidArgumentException
     */
    public function uploadFoundFilesIntoDatabase(Request $request)
    {
        ini_set('memory_limit', '2048M');
        $foundFiles = $request->input('found_files');
        foreach ($foundFiles as $filenamePath) {
            $getID3 = new getID3;
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
                }
            } elseif ($fileExtension === 'jpg') {
                if (JpgFile::where('filename_path', $filenamePath)->doesntExist()) {
                    $pelJpeg = new PelJpeg($filenamePath);
                    $fileMetadata = $getID3->analyze($filenamePath);
                    list($xpTitle, $xpKeyword, $xpComment, $dateTimeOriginal, $hasExifMetadata) =
                        $this->getJpgFileMetadataValues($fileMetadata, $pelJpeg);
                    JpgFile::create([
                        'filename_path' => $filenamePath,
                        'filename' => $fileMetadata['filename'],
                        'xp_title' => $xpTitle,
                        'xp_keywords' => $xpKeyword,
                        'xp_comment' => $xpComment,
                        'datetime_original' => $dateTimeOriginal,
                        'has_exif_metadata' => $hasExifMetadata,
                    ]);
                }
            }
        }
        return redirect('/files');
    }

    /**
     * @param $fileMetadata
     * @param $pelJpeg
     * @return array|RedirectResponse
     */
    public function getJpgFileMetadataValues($fileMetadata, $pelJpeg)
    {
        try {
            $exif = $pelJpeg->getExif();
            $hasExifMetadata = 'no';
            $xpTitle = '';
            $xpKeyword = '';
            $xpComment = '';
            $dateTimeOriginal = '';
            if (!is_null($exif)) {
                $ifd0 = $exif->getTiff()->getIfd();
                $hasExifMetadata = 'yes';
                $xpTitle = $this->getXpTitleValue($ifd0);
                $xpKeyword = $this->getXpKeywordValue($ifd0);
                $xpComment = $this->getXpCommentValue($ifd0);
                if (array_key_exists("EXIF", $fileMetadata['jpg']['exif'])) {
                    $date = date("d/m/Y", strtotime($fileMetadata['jpg']['exif']['EXIF']['DateTimeOriginal']));
                    $dateTimeOriginal = $date;
                }
            }
        } catch (PelInvalidArgumentException $exception) {
            return back()->withErrors($exception->getMessage());
        }
        return array($xpTitle, $xpKeyword, $xpComment, $dateTimeOriginal, $hasExifMetadata);
    }

    /**
     * @param PelIfd|null $ifd0
     * @return mixed|string
     */
    private function getXpTitleValue(?PelIfd $ifd0)
    {
        $entry = $ifd0->getEntry(PelTag::XP_TITLE);
        if (!is_null($entry)) {
            return $entry->getValue();
        } else {
            return '';
        }
    }

    /**
     * @param PelIfd|null $ifd0
     * @return mixed|string
     */
    private function getXpKeywordValue(?PelIfd $ifd0)
    {
        $entry = $ifd0->getEntry(PelTag::XP_KEYWORDS);
        if (!is_null($entry)) {
            return $entry->getValue();
        } else {
            return '';
        }
    }

    /**
     * @param PelIfd|null $ifd0
     * @return mixed|string
     */
    private function getXpCommentValue(?PelIfd $ifd0)
    {
        $entry = $ifd0->getEntry(PelTag::XP_COMMENT);
        if (!is_null($entry)) {
            return $entry->getValue();
        } else {
            return '';
        }
    }

    /**
     * @return Application|Factory|View
     */
    public function routeToFilesIndexPage()
    {
        return view('files.index');
    }
}
