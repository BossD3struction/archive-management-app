@extends('layouts.app')

@section('content')
    <div id="change-max-height" class="container position-relative custom-min-height">
        @if($isEmpty)
            <h1>Found files page</h1>
            <div class="alert alert-danger text-center mt-1">
                <span>No JPG/MP3 files in given directory path found</span>
            </div>
        @endif
        @if(!$isEmpty)
            <form action="/upload/files" method="POST">
                @csrf
                <h1 id="hide-page-title">Found files page</h1>
                <div id="hide-found-files-list" class="found-files-list">
                    <ul class="list-group">
                        @foreach($foundFiles as $foundFile)
                            <li class="list-group-item text-center mt-1">{{ $foundFile }}</li>
                            <input type="hidden" name="found_files[]" value="{{ $foundFile }}">
                        @endforeach
                    </ul>
                </div>
                <div class="input-group justify-content-center">
                    <button id="hide-submit-button" class="btn btn-lg btn-primary w-25 mt-3" onclick="showAlert()"
                            type="submit">
                        Upload
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
        @endif
    </div>
    <script>
        function showAlert() {
            document.getElementById('change-max-height').style.maxHeight = '40vh';
            document.getElementById('custom-alert').style.visibility = 'visible';
            document.getElementById('hide-page-title').style.visibility = 'hidden';
            document.getElementById('hide-found-files-list').style.visibility = 'hidden';
            document.getElementById('hide-submit-button').style.visibility = 'hidden';
        }
    </script>
@endsection
