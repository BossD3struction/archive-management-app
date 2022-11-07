<?php
/** @noinspection PhpUnusedLocalVariableInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Http\Controllers;

use App\DataTables\Mp3FileDataTable;
use App\Models\Mp3File;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Stormiix\EyeD3\EyeD3;

class Mp3FilesController extends Controller
{

    public function renderMp3FilesTable(Mp3FileDataTable $dataTable)
    {
        return $dataTable->render('files.table_mp3');
    }

    /*// looks for .mp3 | .jpg | .png files
    public function findAllSpecifiedFilesInDirectory(Request $request)
    {
        $request->validate(['directory_path' => 'required']);
        $directory = $request->input('directory_path');
        try {
            $files = Finder::create()
                ->in($directory)
                ->ignoreUnreadableDirs()
                ->name(['*.png', '*.jpg', '*.mp3']);
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
    }*/

    /*public function routeToIndexPage()
    {
        return view('files.files');
    }*/

    private function updateMp3MetaData($filename, $title, $artist, $album, $genre, $year)
    {
        $eyed3 = new EyeD3($filename);
        $time_input = strtotime($year . "-01-01");
        $date_input = getDate($time_input);

        $meta = [
            "title" => $title,
            "artist" => $artist,
            "album" => $album,
            "genre" => $genre,
            "year" => $date_input['year']
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
        /*if(File::exists('D:\tmp_media_files_for_bachelor_project\Hudba\NEW_MUSIC\Naruto Shippuden Opening 7 - Toumei Datta Sekai.mp3')) {
            $result = true;
            $text = 'true';
        } else {
            $result = false;
            $text = 'false';
        }
        return view('files.files', ['result' => $result, 'text' => $text]);*/
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
        $genres = array("Blues", "Big Band", "Classic Rock", "Chorus", "Country", "Easy Listening", "Dance", "Acoustic", "Disco", "Humour", "Funk",
            "Speech", "Grunge", "Chanson", "Hip-Hop", "Opera", "Jazz", "Chamber Music", "Metal", "Sonata", "New Age", "Symphony", "Oldies", "Booty Bass",
            "Other", "Primus", "Pop", "Porn Groove", "R&B", "Satire", "Rap", "Slow Jam", "Reggae", "Club", "Rock", "Tango", "Techno", "Samba", "Industrial",
            "Folklore", "Alternative", "Ballad", "Ska", "Power Ballad", "Death Metal", "Rhythmic Soul", "Pranks", "Freestyle", "Soundtrack", "Duet", "Euro-Techno",
            "Punk Rock", "Ambient", "Drum Solo", "Trip-Hop", "A Cappella", "Vocal", "Euro-House", "Jazz+Funk", "Dance Hall", "Fusion", "Goa", "Trance", "Drum & Bass",
            "Classical", "Club-House", "Instrumental", "Hardcore", "Acid", "Terror", "House", "Indie", "Game", "BritPop", "Sound Clip", "Negerpunk", "Gospel", "Polsk Punk",
            "Noise", "Beat", "AlternRock", "Christian Gangsta Rap", "Bass", "Heavy Metal", "Soul", "Black Metal", "Punk", "Crossover", "Space", "Contemporary Christian",
            "Meditative", "Christian Rock", "Instrumental Pop", "Merengue", "Instrumental Rock", "Salsa", "Ethnic", "Thrash Metal", "Gothic", "Anime", "Darkwave", "JPop",
            "Techno-Industrial", "Synthpop", "Electronic", "Abstract", "Pop-Folk", "Art Rock", "Eurodance", "Baroque", "Dream", "Bhangra", "Southern Rock", "Big Beat", "Comedy",
            "Breakbeat", "Cult", "Chillout", "Gangsta Rap", "Downtempo", "Top 40", "Dub", "Christian Rap", "EBM", "Pop/Funk", "Eclectic", "Jungle", "Electro", "Native American",
            "Electroclash", "Cabaret", "Emo", "New Wave", "Experimental", "Psychedelic", "Garage", "Rave", "Global", "Showtunes", "IDM", "Trailer", "Illbient", "Lo-Fi", "Industro-Goth",
            "Tribal", "Jam Band", "Acid Punk", "Krautrock", "Acid Jazz", "Leftfield", "Polka", "Lounge", "Retro", "Math Rock", "Musical", "New Romantic", "Rock & Roll", "Nu-Breakz",
            "Hard Rock", "Post-Punk", "Folk", "Post-Rock", "Folk-Rock", "Psytrance", "National Folk", "Shoegaze", "Swing", "Space Rock", "Fast Fusion", "Trop Rock", "Bebob", "World Music",
            "Latin", "Neoclassical", "Revival", "Audiobook", "Celtic", "Audio Theatre", "Bluegrass", "Neue Deutsche Welle", "Avantgarde", "Podcast", "Gothic Rock", "Indie Rock", "Progressive Rock",
            "G-Funk", "Psychedelic Rock", "Dubstep", "Symphonic Rock", "Garage Rock", "Slow Rock", "Psybient");
        $file = Mp3File::find($id);
        return view('files.edit', ['file' => $file, 'genres' => $genres]);
        //return view('files.edit')->with('file', $file);
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
            'album' => 'required',
            //'genre' => 'required',
            //'year' => 'required',
            'year' => 'required|regex:/^[1-9][0-9]*$/|integer|between:1900,' . date("Y")
        ]);

        $filename_path = $request->input('filename_path');
        $title = $request->input('title');
        $artist = $request->input('artist');
        $album = $request->input('album');
        $genre = $request->get('genre');
        $year = $request->input('year');

        $file = Mp3File::where('id', $id)
            ->update([
                'title' => $title,
                'artist' => $artist,
                'album' => $album,
                'genre' => $genre,
                'year' => $year
            ]);

        $this->updateMp3MetaData($filename_path, $title, $artist, $album, $genre, $year);
        return redirect('/mp3/table');
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
        return redirect('/mp3/table');
    }
}
