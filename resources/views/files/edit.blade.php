@extends('layouts.app')

@section('content')
    {{--<div class="mt-5 pt-5 pb-5 text-black">--}}
    <div class="text-black">
        <div class="text-center text-uppercase fw-bold">
            <h1>MP3 file</h1>
        </div>
    </div>

    <div class="form-group text-center mx-auto w-50 mb-3">
        <form action="/mp3/files/{{ $file->id }}" method="POST">
            @csrf
            @method('PUT')
            {{--<div class="mb-3">
                <label for="id" class="fw-bold">ID</label>
                <input type="text" class="form-control form-control-lg" name="id" id="id"
                       value="{{ $file->id }}" autocomplete="off" readonly>
            </div>--}}
            <div class="mb-3">
                <label for="filename_path" class="fw-bold">FILENAME PATH</label>
                <input type="text" class="form-control form-control-lg" name="filename_path" id="filename_path"
                       value="{{ $file->filename_path }}" autocomplete="off" readonly>
            </div>
            <div class="mb-3">
                <label for="filename" class="fw-bold">FILENAME</label>
                <input type="text" class="form-control form-control-lg" name="filename" id="filename"
                       value="{{ $file->filename }}" autocomplete="off" readonly>
            </div>
            <div class="mb-3">
                <label for="title" class="fw-bold">TITLE</label>
                <input type="text" class="form-control form-control-lg" name="title" id="title"
                       value="{{ $file->title }}" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="artist" class="fw-bold">ARTIST</label>
                <input type="text" class="form-control form-control-lg" name="artist" id="artist"
                       value="{{ $file->artist }}" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="album" class="fw-bold">ALBUM</label>
                <input type="text" class="form-control form-control-lg" name="album" id="album"
                       value="{{ $file->album }}" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="genre" class="fw-bold">GENRE</label>
                <select class="form-select form-select-lg" name="genre" id="genre" onchange="">
                    @foreach($genres as $genre)
                        @if($genre === $file->genre)
                            <option selected value="{{$genre}}">{{$genre}}</option>
                        @endif
                        @if($genre !== $file->genre)
                            <option value="{{$genre}}">{{$genre}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            {{--<div class="mb-3">
                <label for="year" class="fw-bold">YEAR</label>
                <input type="date" class="form-control form-control-lg" name="year" id="year"
                       value="{{ $file->year }}-01-01" autocomplete="off">
            </div>--}}
            <div class="mb-3">
                <label for="year" class="fw-bold">YEAR</label>
                <input type="number" class="form-control form-control-lg" name="year" id="year" placeholder="YYYY"
                       value="{{ substr($file->year, 0, 4) }}" autocomplete="off" min="1900" max="{{date("Y")}}">
                {{--<script>
                    document.querySelector("input[type=number]")
                        .oninput = e => console.log(new Date(e.target.valueAsNumber, 0, 1));
                </script>--}}
            </div>
            @if($errors->any())
                <div class="alert-danger text-center mb-3 p-3">
                    @foreach($errors->all() as $error)
                        <li class="list-unstyled">
                            {{ $error }}
                        </li>
                    @endforeach
                </div>
            @endif
            @if(File::exists($file->filename_path))
                <button class="btn btn-primary btn-lg w-50" type="submit">Update</button>
            @endif
            @if(File::missing($file->filename_path))
                <button class="btn btn-primary btn-lg w-50" type="submit" disabled>Update</button>
            @endif
        </form>
        <form action="/mp3/files/{{ $file->id }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-lg w-50 mt-3">
                Delete
            </button>
        </form>
    </div>
@endsection
