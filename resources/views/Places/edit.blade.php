@extends("layout.master")
@section("css-scripts")
    <link rel="stylesheet" href="{{ asset('assets/css/create-pages.css') }}">
@endsection
@section("content")
    <!-- breadcrumbs -->
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>{{ __("nl-words.Places") }}</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li>
                            <a href="{{ url('/') }}">Home</a>
                        </li>
                        <li>
                            <a href="{{ route('places.index') }}">{{ __("nl-words.Places") }}</a>
                        </li>
                        <li class="active">
                            <a href="{{ route('places.edit', $place->id) }}">{{ __("nl-words.Edit place") }}</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumbs -->
    <div class="col-lg-12 table-card">
        <div class="card">
            <div class="card-header">
                <h1>{{ __("nl-words.Edit place") }}</h1>
            </div>
            <div class="card-body card-block">
                <form action="{{ route('places.update', $place->id) }}" method="post" class="">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-control-label">{{ __("nl-words.Name") }}</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $place->name) }}" placeholder="Enter place name.." class="form-control is-valid @error('name')is-invalid @enderror">
                            </div>
                            @error("name")
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="number" class=" form-control-label">{{ __("nl-words.Number") }}<span class="text-muted">(optional)</span></label>
                                <input type="number" id="number" name="number" value="{{ old('number', $place->number) }}" placeholder="Enter place number.." class="form-control is-valid @error('number')is-invalid @enderror">
                            </div>
                            @error("number")
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success submit-btn">{{ __("nl-words.Edit place") }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
