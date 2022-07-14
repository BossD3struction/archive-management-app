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
            <h1>Found files page</h1>
            <a href="/files" class="btn btn-success" role="button">redirect to index page</a>
            <div class="mt-2">
                <h2>Files</h2>
                <ul>
                    @foreach($files as $file)
                        <li>{{ $file }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    {{--@endif--}}
@endsection
