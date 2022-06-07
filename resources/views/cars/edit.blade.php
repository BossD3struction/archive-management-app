@extends('layouts.app')

@section('content')
    <div class="mt-5 pt-5 pb-5 text-black">
        <div class="text-center text-uppercase fw-bold">
            <h1>Update car</h1>
        </div>
    </div>

    <div class="form-group text-center mx-auto w-50">
        <form action="/cars/{{ $car->id }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <input type="text" class="form-control form-control-lg" name="name" id="name" value="{{ $car->name }}"
                       placeholder="Brand name..." autocomplete="off">
            </div>
            <div class="mb-3">
                <input type="text" class="form-control form-control-lg" name="founded" id="founded" value="{{ $car->founded }}"
                       placeholder="Founded..." autocomplete="off">
            </div>
            <div class="mb-3">
                <input type="text" class="form-control form-control-lg" name="description" id="description" value="{{ $car->description }}"
                       placeholder="Description..." autocomplete="off">
            </div>
            <div>
                <button class="btn btn-primary btn-lg w-50" type="submit">Update</button>
            </div>
        </form>
    </div>
@endsection
