@extends('layouts.app')

@section('content')
    <div class="mt-5 pt-5 pb-5 text-black">
        <div class="text-center text-uppercase">
            <h1>Cars</h1>
        </div>

        <div class="pt-5">
            <a href="cars/create" class="btn btn-success mb-5" role="button">
                Add a new car
            </a>
        </div>

        <div>
            <hr class="bg-black border-2 border-top border-dark">
            @foreach($cars as $car)
                <div class="m-auto">
                    <div class="d-grid gap-2 d-flex justify-content-end">
                        <a href="cars/{{ $car->id }}/edit" class="btn btn-primary mb-2" role="button">
                            Edit
                        </a>
                        <form action="/cars/{{ $car->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger mb-2">
                                Delete
                            </button>
                        </form>
                    </div>
                    @if($car->image_path)
                        <img src="{{ asset('images/' . $car->image_path) }}" alt="" class="img-thumbnail w-25">
                    @endif
                    <p class="text-lg-start text-uppercase text-primary fst-italic fw-bold">
                        Founded: {{ $car->founded }}
                    </p>
                    <h2 id="model">
                        <a href="/cars/{{ $car->id }}">
                            {{ $car->name }}
                        </a>
                    </h2>
                    <p class="text-lg-start">
                        {{ $car->description }}
                    </p>
                    <hr class="bg-black border-2 border-top border-dark">
                </div>
            @endforeach
        </div>
    </div>
@endsection
