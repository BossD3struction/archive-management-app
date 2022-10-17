@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Files page</h1>
        <form action="/found/files" method="POST" autocomplete="on">
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
@endsection
