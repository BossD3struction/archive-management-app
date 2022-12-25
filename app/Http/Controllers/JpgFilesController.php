<?php

namespace App\Http\Controllers;

use App\DataTables\JpgFilesDataTable;
use App\Models\JpgFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use lsolesen\pel\PelEntryWindowsString;
use lsolesen\pel\PelException;
use lsolesen\pel\PelIfd;
use lsolesen\pel\PelInvalidArgumentException;
use lsolesen\pel\PelInvalidDataException;
use lsolesen\pel\PelJpeg;
use lsolesen\pel\PelTag;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class JpgFilesController extends Controller
{
    public function renderJpgFilesTable(JpgFilesDataTable $dataTable)
    {
        return $dataTable->render('tables.jpg');
    }

    /**
     * @throws PelException
     * @throws PelInvalidArgumentException
     * @throws PelInvalidDataException
     */
    private function updateJpgMetadata($filenamePath, $title, $tags, $comments)
    {
        $jpeg = new PelJpeg($filenamePath);
        $exif = $jpeg->getExif();

        if (!is_null($exif)) {
            $ifd0 = $exif->getTiff()->getIfd();
            $this->setXpTitleValue($ifd0, $title);
            $this->setXpKeywordsValue($ifd0, $tags);
            $this->setXpCommentValue($ifd0, $comments);
            $jpeg->saveFile($filenamePath);
        }
    }

    public function edit(int $id)
    {
        $file = JpgFile::find($id);
        return view('files.jpg.edit', ['file' => $file]);
    }

    /**
     * @throws PelException
     * @throws PelInvalidArgumentException
     * @throws PelInvalidDataException
     */
    public function update(Request $request, int $id)
    {
        $filenamePath = $request->input('filename_path');
        $title = $request->input('title');
        $tags = $request->input('tags');
        $comments = $request->input('comments');

        if (File::exists($filenamePath)) {
            JpgFile::where('id', $id)
                ->update([
                    'title' => $title ?? '',
                    'tags' => $tags ?? '',
                    'comments' => $comments ?? ''
                ]);

            $this->updateJpgMetadata($filenamePath, $title, $tags, $comments);
            flash()->addSuccess('file metadata updated successfully');
        } else {
            throw new FileNotFoundException($filenamePath);
        }
        return redirect('/jpg/table');
    }

    public function destroy(int $id)
    {
        JpgFile::find($id)->delete();
        flash()->addSuccess('file record deleted successfully');
        return redirect('/jpg/table');
    }

    /**
     * @throws PelException
     * @throws PelInvalidDataException
     */
    function setXpTitleValue(?PelIfd $ifd0, $xp_title): void
    {
        $entry = $ifd0->getEntry(PelTag::XP_TITLE);
        if (!is_null($entry)) {
            $entry->setValue($xp_title);
        } else {
            $ifd0->addEntry(new PelEntryWindowsString(PelTag::XP_TITLE, $xp_title));
        }
    }

    /**
     * @throws PelException
     * @throws PelInvalidDataException
     */
    function setXpKeywordsValue(?PelIfd $ifd0, $xp_keywords): void
    {
        $entry = $ifd0->getEntry(PelTag::XP_KEYWORDS);
        if (!is_null($entry)) {
            $entry->setValue($xp_keywords);
        } else {
            $ifd0->addEntry(new PelEntryWindowsString(PelTag::XP_KEYWORDS, $xp_keywords));
        }
    }

    /**
     * @throws PelException
     * @throws PelInvalidDataException
     */
    function setXpCommentValue(?PelIfd $ifd0, $xp_comment): void
    {
        $entry = $ifd0->getEntry(PelTag::XP_COMMENT);
        if (!is_null($entry)) {
            $entry->setValue($xp_comment);
        } else {
            $ifd0->addEntry(new PelEntryWindowsString(PelTag::XP_COMMENT, $xp_comment));
        }
    }
}
