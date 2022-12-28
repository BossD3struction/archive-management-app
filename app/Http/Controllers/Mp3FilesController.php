<?php

namespace App\Http\Controllers;

use App\DataTables\Mp3FilesDataTable;
use App\Models\Mp3File;
use getID3;
use getid3_writetags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Stormiix\EyeD3\EyeD3;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class Mp3FilesController extends Controller
{
    public function renderMp3FilesTable(Mp3FilesDataTable $dataTable)
    {
        return $dataTable->render('tables.mp3');
    }

    private function updateMp3MetaData($filenamePath, $title, $artist, $album, $year, $genre)
    {
        $getID3 = new getID3;
        $tagWriter = new getid3_writetags;
        $tagWriter->filename = $filenamePath;
        $tagWriter->tagformats = array('id3v2.4');
        $tagWriter->overwrite_tags = true;
        $tagWriter->remove_other_tags = true;
        $tagWriter->tag_encoding = 'UTF-8';

        $TagData = array(
            'title' => array($title ?? ''),
            'artist' => array($artist ?? ''),
            'album' => array($album ?? ''),
            'year' => array($year),
            'genre' => array($genre)
        );

        $tagWriter->tag_data = $TagData;
        $tagWriter->WriteTags();
    }

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
        sort($genres);
        $file = Mp3File::find($id);
        return view('files.mp3.edit', ['file' => $file, 'genres' => $genres]);
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'year' => 'required|regex:/^[1-9][0-9]*$/|integer|between:1860,' . date("Y")
        ]);

        $filenamePath = $request->input('filename_path');
        $title = $request->input('title');
        $artist = $request->input('artist');
        $album = $request->input('album');
        $year = $request->input('year');
        $genre = $request->input('genres');

        if (File::exists($filenamePath)) {
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
        } else {
            throw new FileNotFoundException($filenamePath);
        }
        return redirect('/mp3/table');
    }

    public function destroy(int $id)
    {
        Mp3File::find($id)->delete();
        flash()->addSuccess('file record deleted successfully');
        return redirect('/mp3/table');
    }
}
