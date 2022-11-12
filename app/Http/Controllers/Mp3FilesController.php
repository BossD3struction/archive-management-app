<?php

namespace App\Http\Controllers;

use App\DataTables\Mp3FilesDataTable;
use App\Models\Mp3File;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Stormiix\EyeD3\EyeD3;

class Mp3FilesController extends Controller
{

    /**
     * @param Mp3FilesDataTable $dataTable
     * @return mixed
     */
    public function renderMp3FilesTable(Mp3FilesDataTable $dataTable)
    {
        return $dataTable->render('tables.mp3');
    }

    /**
     * @param $filenamePath
     * @param $title
     * @param $artist
     * @param $album
     * @param $year
     * @param $genre
     * @return void
     */
    private function updateMp3MetaData($filenamePath, $title, $artist, $album, $year, $genre)
    {
        $meta = [
            "title" => $title ?? '',
            "artist" => $artist ?? '',
            "album" => $album ?? '',
            "year" => $year,
            "genre" => $genre
        ];
        $eyed3 = new EyeD3($filenamePath);
        $eyed3->updateMeta($meta);
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
        return view('files.mp3.edit', ['file' => $file, 'genres' => $genres]);
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
            'year' => 'required|regex:/^[1-9][0-9]*$/|integer|between:1900,' . date("Y")
        ]);

        $filenamePath = $request->input('filename_path');
        $title = $request->input('title');
        $artist = $request->input('artist');
        $album = $request->input('album');
        $year = $request->input('year');
        $genre = $request->input('genres');

        Mp3File::where('id', $id)
            ->update([
                'title' => $title ?? '',
                'artist' => $artist ?? '',
                'album' => $album ?? '',
                'year' => $year,
                'genre' => $genre
            ]);

        $this->updateMp3MetaData($filenamePath, $title, $artist, $album, $year, $genre);
        flash()->addSuccess('file metadata updated successfully');
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
        Mp3File::find($id)->delete();
        flash()->addSuccess('file record deleted successfully');
        return redirect('/mp3/table');
    }
}
