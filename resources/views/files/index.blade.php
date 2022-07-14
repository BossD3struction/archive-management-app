@extends('layouts.app')

@section('content')
    <div class="mt-3 row d-flex justify-content-center">
        <h1>Index page</h1>
        <form class="mt-3" action="/files/found" method="POST">
            @csrf
            <div class="input-group">
                <span class="input-group-text" id="basic-bi-search"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control" placeholder="Directory path" aria-label="Directory path"
                       name="directory_path" id="directory_path" aria-describedby="basic-bi-search">
                <button type="submit" class="btn btn-primary w-25">Search</button>
            </div>
        </form>
    </div>
    @if($errors->any())
        <div class="alert-danger text-center mt-5 p-3">
            @foreach($errors->all() as $error)
                <li class="list-unstyled">
                    {{ $error }}
                </li>
            @endforeach
        </div>
    @endif
    {{--@if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif--}}
    {{--<h2 class="mt-3">Files</h2>
    <ul>
        @foreach($files as $file)
            <li>{{ $file }}</li>
        @endforeach
    </ul>--}}
@endsection
