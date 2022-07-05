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
                    <h1>{{ __("nl-words.Users") }}</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li>
                            <a href="{{ url('/') }}">{{ __("nl-words.Home") }}</a>
                        </li>
                        <li>
                            <a href="{{ route('users.index') }}">{{ __("nl-words.Users") }}</a>
                        </li>
                        <li class="active">
                            <a href="{{ route('users.create') }}">{{ __("nl-words.Create user") }}</a>
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
                <h1>{{ __("nl-words.Add New User") }}</h1>
            </div>
            <div class="card-body card-block">
                <form action="{{ route('users.store') }}" method="post" class="">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fname" class="form-control-label">{{ __("nl-words.firstName") }}</label>
                                <input type="text" id="fname" name="fname" value="{{ old('fname') }}" placeholder="Enter first name.." class="form-control is-valid @error('fname')is-invalid @enderror">
                            </div>
                            @error("fname")
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lname" class=" form-control-label">{{ __("nl-words.lastName") }}</label>
                                <input type="text" id="lname" name="lname" value="{{ old('lname') }}" placeholder="Enter last name.." class="form-control is-valid @error('lname')is-invalid @enderror">
                            </div>
                            @error("lname")
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-control-label">{{ __("nl-words.Email") }}</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="{{ __("words.email_placeholder") }}" class="form-control is-valid @error('email')is-invalid @enderror">
                            </div>
                            @error("email")
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password" class=" form-control-label">{{ __("nl-words.Password") }}</label>
                                <input type="password" id="password" name="password" value="{{ old('password') }}" placeholder="{{ __("words.password_placeholder") }}" class="form-control is-valid @error('password')is-invalid @enderror">
                            </div>
                            @error("password")
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="busNo" class="form-control-label">{{ __("nl-words.Bus No") }}</label>
                                <input type="text" id="busNo" name="busNo" value="{{ old('busNo') }}" placeholder="{{ __("words.bus_no_placeholder") }}" class="form-control is-valid @error('busNo')is-invalid @enderror">
                            </div>
                            @error("busNo")
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role" class=" form-control-label">{{ __("nl-words.role") }}</label>
                                <select id="role" name="role" class="custom-select form-control is-valid @error('role')is-invalid @enderror">
                                    <option value="0" {{ old('role') == 0 ? "selected" : ""}}>{{ __("nl-words.User") }}</option>
                                    <option value="1" {{ old('role') == 1 ? "selected" : ""}}>{{ __("nl-words.admin") }}</option>
                                </select>
                            </div>
                            @error("role")
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success submit-btn">{{ __("nl-words.save") }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
