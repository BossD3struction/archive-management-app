@extends('layouts.app')

@section('content')
    <div class="container position-relative custom-min-height">
        <form class="homepage-form" action="/found/files" method="POST" autocomplete="on">
            @csrf
            <div class="input-group input-group-lg">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control" aria-label="Directory" placeholder="Enter directory path"
                       name="directory" id="directory" autocomplete="off">
                <button class="btn btn-primary w-25" onclick="showAlert()" type="submit">
                    Search
                </button>
            </div>
        </form>
        <div id="custom-alert"
             class="rounded border border-1 alert-secondary position-absolute top-100 end-0 mb-5 p-1 w-100 input-group input-group-lg"
             style="visibility: hidden">
                <span class="input-group-text p-3">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </span>
            <input type="text" class="form-control text-center" aria-label="loading" autocomplete="off"
                   value="Processing..." style="font-size:25px">
        </div>
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
    <script>
        function showAlert() {
            document.getElementById('custom-alert').style.visibility = 'visible';
        }
    </script>
@endsection
