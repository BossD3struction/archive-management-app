@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="/upload/files" method="POST">
            @csrf
            <h1>Found files page</h1>
            <div>
                <ul>
                    @foreach($files as $file)
                        <li>{{ $file }}</li>
                        <input type="hidden" name="found_files[]" value="{{$file}}">
                    @endforeach
                </ul>
            </div>
            <div class="input-group">
                <button type="submit" class="btn btn-primary w-25">Upload files</button>
            </div>
        </form>
    </div>
@endsection
