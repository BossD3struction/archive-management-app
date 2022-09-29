@extends('layouts.app')

@section('content')
    {{--@if($errors->any())
        <div class="alert-danger text-center mt-5 p-3">
            @foreach($errors->all() as $error)
                <li class="list-unstyled">
                    {{ $error }}
                </li>
            @endforeach
        </div>
    @else--}}
    <div class="mt-3">
        <form class="mt-3" action="/upload/files" method="POST" autocomplete="on">
            @csrf
            <h1>Found files page</h1>
            <a href="/files" class="btn btn-success" role="button">redirect to index page</a>
            <div class="mt-2">
                <h2>Files</h2>
                <ul>
                    @foreach($files as $file)
                        <li>{{ $file }}</li>
                        <input type="hidden" name="found_files[]" value="{{$file}}">
                    @endforeach
                </ul>
            </div>
            <div class="input-group">
                {{--<span class="input-group-text" id="basic-bi-search"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control" placeholder="Directory path" aria-label="Directory path"
                       name="directory_path" id="directory_path" aria-describedby="basic-bi-search">--}}
                {{--<input type="hidden" name="found_files" id="found_files" value="{{$files}}">--}}
                <button type="submit" class="btn btn-primary w-25">Upload files</button>
            </div>
        </form>
    </div>
    {{--@endif--}}
@endsection
