@extends('layouts.app')

@section('content')
    <div class="text-black">
        <div class="text-center text-uppercase fw-bold">
            <h1>JPG file</h1>
        </div>
    </div>

    <div class="form-group text-center mx-auto w-50 mb-3">
        <form action="/files/jpg/{{ $file->id }}" method="POST">
            @csrf
            @method('PUT')
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
                <label for="tags" class="fw-bold">TAGS</label>
                <input type="text" class="form-control form-control-lg" name="tags" id="tags"
                       value="{{ $file->tags }}" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="comments" class="fw-bold">COMMENTS</label>
                <input type="text" class="form-control form-control-lg" name="comments" id="comments"
                       value="{{ $file->comments }}" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="date" class="fw-bold">DATE</label>
                <input type="date" class="form-control form-control-lg" name="date" id="date"
                       value="{{ $date }}" autocomplete="off">
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
        <form action="/files/jpg/{{ $file->id }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-lg w-50 mt-3">
                Delete
            </button>
        </form>
    </div>
@endsection
