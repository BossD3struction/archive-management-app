<?php

namespace App\Http\Controllers;

use App\DataTables\JpgFilesDataTable;
use App\Models\JpgFile;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use lsolesen\pel\PelEntryWindowsString;
use lsolesen\pel\PelException;
use lsolesen\pel\PelIfd;
use lsolesen\pel\PelInvalidArgumentException;
use lsolesen\pel\PelInvalidDataException;
use lsolesen\pel\PelJpeg;
use lsolesen\pel\PelTag;

class JpgFilesController extends Controller
{

    /**
     * @param JpgFilesDataTable $dataTable
     * @return mixed
     */
    public function renderJpgFilesTable(JpgFilesDataTable $dataTable)
    {
        return $dataTable->render('tables.jpg');
    }

    /**
     * @param $filenamePath
     * @param $title
     * @param $tags
     * @param $comments
     * @return void
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(int $id)
    {
        $file = JpgFile::find($id);
        return view('files.jpg.edit', ['file' => $file]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Application|Redirector|RedirectResponse
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

        JpgFile::where('id', $id)
            ->update([
                'title' => $title ?? '',
                'tags' => $tags ?? '',
                'comments' => $comments ?? ''
            ]);

        $this->updateJpgMetadata($filenamePath, $title, $tags, $comments);
        flash()->addSuccess('file metadata updated successfully');
        return redirect('/jpg/table');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(int $id)
    {
        JpgFile::find($id)->delete();
        flash()->addSuccess('file record deleted successfully');
        return redirect('/jpg/table');
    }

    /**
     * @param PelIfd|null $ifd0
     * @param $xp_title
     * @return void
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
     * @param PelIfd|null $ifd0
     * @param $xp_keywords
     * @return void
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
     * @param PelIfd|null $ifd0
     * @param $xp_comment
     * @return void
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
