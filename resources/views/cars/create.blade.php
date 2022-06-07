@extends('layouts.app')

@section('content')
    <!--suppress HtmlFormInputWithoutLabel -->
    <div class="mt-5 pt-5 pb-5 text-black">
        <div class="text-center text-uppercase fw-bold">
            <h1>Create car</h1>
        </div>
    </div>

    <div class="form-group text-center mx-auto w-50">
        <form action="/cars" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <input type="file" class="form-control form-control-lg" name="image" id="image" autocomplete="off">
            </div>
            <div class="mb-3">
                <input type="text" class="form-control form-control-lg" name="name" id="name"
                       placeholder="Brand name..." autocomplete="off">
            </div>
            <div class="mb-3">
                <input type="text" class="form-control form-control-lg" name="founded" id="founded"
                       placeholder="Founded..." autocomplete="off">
            </div>
            <div class="mb-3">
                <input type="text" class="form-control form-control-lg" name="description" id="description"
                       placeholder="Description..." autocomplete="off">
            </div>
            <div>
                <button class="btn btn-success btn-lg w-50" type="submit">Submit</button>
            </div>
        </form>
        @if($errors->any())
            <div class="alert-danger text-center mt-5 p-3">
                @foreach($errors->all() as $error)
                    <li class="list-unstyled">
                        {{ $error }}
                    </li>
                @endforeach
            </div>
        @endif
    </div>
@endsection
