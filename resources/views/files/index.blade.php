@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Files page</h1>
        <form action="/found/files" method="POST" autocomplete="on">
            @csrf
            <div class="input-group input-group-lg">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control" aria-label="Directory" placeholder="Enter directory path"
                       value="D:\tmp_media_files_for_bachelor_project\"
                       name="directory" id="directory" autocomplete="off">
                <button type="submit" class="btn btn-primary w-25">Search</button>
            </div>
        </form>
        @if($errors->any())
            <div class="alert alert-danger text-center mt-5">
                @foreach($errors->all() as $error)
                    <li class="list-unstyled">
                        {{ $error }}
                    </li>
                @endforeach
            </div>
        @endif
    </div>
@endsection
