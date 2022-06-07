@extends('layouts.app')

@section('content')
    <div class="mt-4 text-black">
        <div class="text-center text-uppercase fw-bold">
            <img src="{{ asset('images/' . $car->image_path) }}" alt="" class="img-thumbnail w-75">
            <h1>{{ $car->name }}</h1>
        </div>

        <div class="m-auto text-center mt-3">
            <span class="text-uppercase text-primary fst-italic fw-bold">
                    Founded: {{ $car->founded }}
            </span>
            <p class="text-lg-center mt-2">
                {{ $car->description }}
            </p>
            <table class="table table-striped text-center mx-auto">
                <thead>
                <tr>
                    <th scope="col">Model</th>
                    <th scope="col">Engine</th>
                    <th scope="col">Date</th>
                </tr>
                </thead>
                <tbody>
                @forelse($car->carModels as $model)
                    <tr>
                        <td>
                            {{ $model->model_name }}
                        </td>
                        <td>
                            @foreach($car->engines as $engine)
                                @if($model->id == $engine->model_id)
                                    {{ $engine->engine_name }}
                                @endif
                            @endforeach
                        </td>

                        <td>
                            {{ date('d-m-Y', strtotime($model->productionDate->created_at)) }}
                        </td>
                    </tr>
                @empty
                    <p>
                        No car models found!
                    </p>
                @endforelse
                </tbody>
            </table>
            <p class="text-lg-start">
                Product types:
                @forelse($car->products as $product)
                    {{ $product->name }}
                @empty
                    No car product description
            @endforelse
        </div>
    </div>
@endsection
