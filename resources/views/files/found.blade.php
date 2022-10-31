@extends('layouts.app')

@section('content')
    <div class="container">
        @if($isEmpty)
            <h1>Found files page</h1>
            <div class="alert alert-danger text-center mt-1">
                <span>No .mp3 files in given directory path found</span>
            </div>
        @endif
        @if(!$isEmpty)
            <form action="/upload/files" method="POST">
                @csrf
                <h1>Found files page</h1>
                <div class="found-files-list">
                    <ul class="list-group">
                        @foreach($files as $file)
                            <li class="list-group-item text-center mt-1">{{ $file }}</li>
                            <input type="hidden" name="found_files[]" value="{{$file}}">
                        @endforeach
                    </ul>
                </div>
                <div class="input-group justify-content-center">
                    <button type="submit" class="btn btn-primary w-25 mt-3">Upload files</button>
                </div>
            </form>
        @endif
    </div>
@endsection
