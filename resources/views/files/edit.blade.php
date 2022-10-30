@extends('layouts.app')

@section('content')
    {{--<div class="mt-5 pt-5 pb-5 text-black">--}}
    <div class="text-black">
        <div class="text-center text-uppercase fw-bold">
            <h1>MP3 file</h1>
        </div>
    </div>

    <div class="form-group text-center mx-auto w-50">
        <form action="/files/{{ $file->id }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="id" class="fw-bold">ID</label>
                <input type="text" class="form-control form-control-lg" name="id" id="id"
                       value="{{ $file->id }}" autocomplete="off" readonly>
            </div>
            <div class="mb-3">
                <label for="filename_path" class="fw-bold">FILENAME_PATH</label>
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
            <div>
                <button class="btn btn-primary btn-lg w-50" type="submit">Update</button>
            </div>
        </form>
        <form action="/files/{{ $file->id }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-lg w-50 mt-3">
                Delete
            </button>
        </form>
    </div>
@endsection
