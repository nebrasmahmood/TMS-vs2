@extends("layout.master")
@section("css-scripts")
    <link rel="stylesheet" href="{{ asset('assets/css/create-pages.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom-switch.css') }}">
@endsection
@section("content")
    <!-- breadcrumbs -->
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>{{ __('words.categories') }}</h1>
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
                            <a href="{{ route('categories.index') }}">{{ __('words.categories') }}</a>
                        </li>
                        <li class="active">
                            <a href="{{ route('categories.create') }}">{{ __('words.create_cat') }}</a>
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
                <h1>{{ __('words.Add_new_cat') }}</h1>
            </div>
            <div class="card-body card-block">
                <form action="{{ route('categories.store') }}" method="post" class="">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="name" class="form-control-label">{{ __('words.Name') }}</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="{{ __('words.Enter_category_name') }}" class="form-control is-valid @error('name')is-invalid @enderror">
                            </div>
                            @error("name")
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="description" class=" form-control-label">{{ __('words.description') }}<span class="text-muted">(optional)</span></label>
                                <textarea id="description" name="description" placeholder="{{ __('words.Enter_category_description') }}" class="form-control is-valid @error('description')is-invalid @enderror">{{ old('description') }}</textarea>
                            </div>
                            @error("description")
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="form-group custom-switch">
                                <label class="">{{ __('words.Status') }}</label>
                                <input type="checkbox" class="custom-switch-input checkbox" id="customSwitch1" name="status" value="1" {{ old('status') == 1 ? 'checked' : '' }}>
                                <label class="custom-switch-label" for="customSwitch1" data-before="Unactive"></label>
                            </div>
                            @error("status")
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success submit-btn">{{ __('words.Save_changes') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(".checkbox").change(function() {
            if(this.checked) {
                $('label.custom-switch-label').attr('data-before','Active');
            }else{
                $('label.custom-switch-label').attr('data-before','Unactive');
            }
        });
    </script>
@endpush
