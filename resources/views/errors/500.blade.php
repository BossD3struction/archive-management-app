@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="alert alert-danger text-center mt-5">
            {{ $exception->getMessage() }}
        </div>
    </div>
@endsection
