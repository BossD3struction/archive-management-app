@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Files page</h1>
        <form action="/found/files" method="POST" autocomplete="on">
            @csrf
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control" aria-label="Directory path" placeholder="Directory path"
                       name="directory_path" id="directory_path" autocomplete="off">
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
