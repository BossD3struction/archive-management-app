<?php

namespace App\Http\Controllers;

use Exception;
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
                ->name(['*.png', '*.jpg', '*.mp3']);
        //} catch (DirectoryNotFoundException $exception) {
        } catch (Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
        return view('files.found', [
            'files' => $files
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        /*$directory = "C:\\xampp\\htdocs\\bachelor_project\\test_files";
        $files = Finder::create()
            ->in($directory)
            ->name(['*.png', '*.jpg', '*.mp3']);
        return view('files.index', [
            'files' => $files
        ]);*/
        return view('files.index');
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
