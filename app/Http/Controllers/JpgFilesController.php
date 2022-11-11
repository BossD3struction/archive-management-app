<?php

namespace App\Http\Controllers;

use App\DataTables\JpgFilesDataTable;
use App\Models\JpgFile;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

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
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(int $id)
    {
        $file = JpgFile::find($id);
        $date = str_replace('/', '-', $file->date);
        $date = date('Y-m-d', strtotime($date));
        return view('files.jpg.edit', ['file' => $file, 'date' => $date]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $title = $request->input('title');
        $tags = $request->input('tags');
        $comments = $request->input('comments');
        $date = $request->input('date');

        var_dump($title);
        echo '</br>';
        var_dump($tags);
        echo '</br>';
        var_dump($comments);
        echo '</br>';
        var_dump($date);
        echo '</br>';
        $ree = date("d/m/Y", strtotime($date));
        var_dump('date converted ' . $ree);
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
}
