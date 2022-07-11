@extends('layouts.app')

@section('content')
    <div class="mt-3">
        <h2>Files</h2>
        <ul>
            @foreach($files as $file)
                <li>{{ $file }}</li>
            @endforeach
        </ul>
    </div>
@endsection

