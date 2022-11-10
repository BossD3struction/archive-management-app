<?php

namespace App\Http\Controllers;

use App\DataTables\JpgFilesDataTable;
use App\Models\JpgFile;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
        return view('files.jpg.edit', ['file' => $file]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
