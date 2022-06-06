@extends("layout.master")
@section("css-scripts")
    <link href="{{ asset('assets/css/index-pages.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/create-pages.css') }}">
    <link href="{{ asset('assets/css/select2.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sumoselect.css')}}">
    <style>
        .submit-btn{
            border-radius: 0.25rem;
            height: 40px;
            width: 100%;
            margin-bottom: 2px;
            margin-top: 0px !important;
        }
    </style>
@endsection
@section("content")
    <!-- breadcrumbs -->
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>{{ __('words.Total Hours') }}</h1>
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
                        <li class="active">
                            <a href="{{ route('totalHours.index') }}">{{ __("words.Total Hours") }}</a>
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
                <h1>{{ __('words.Total Hours') }}</h1>
            </div>
            <div class="card-body card-block">
                <form action="{{ route('totalHours.getHours') }}" method="post" class="">
                    @csrf
                    <div class="row" style="margin-top: 0px !important;">
                        <div class="col-md-11">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="user_id" class="col-form-label">Username</label>
                                        <select class="form-control userSelect" id="user_id" name="user_id">
                                            <option value="0" selected>{{ __('words.choose_username') }}</option>
                                        </select>
                                    </div>
                                    @error("user_id")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="week_num" class="col-form-label">Week Number</label>
                                        <select class="form-control sumoSelect is-valid" id="week_num" name="week_num">
                                            @for($i = 1; $i < 54; $i++)
                                                <option class="option{{ $i }}" value="{{ $i }}" >{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    @error("week_num")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1" style="display: flex;justify-content: center;align-items: end;">
                            <button type="submit" class="btn btn-success submit-btn">{{ __("words.search") }}</button>
                        </div>
                    </div>
                </form>

                @if (isset($data))
                <div class="table-responsive mt-4">
                    <table class="table table-striped">
                        <thead>
                        <tr class="table-head">
                            <th scope="col">{{ __('words.User') }}</th>
                            <th scope="col">{{ __('words.Total Hours') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $data['user']['text'] }}</td>
                                <td>{{ $data['totalHours'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('/assets/js/select2.min.js')}}"></script>
    <script src="{{ asset('assets/js/sumoselect.js')}}"></script>
    <script>
        $('.userSelect').select2({
            placeholder: "{{ __('words.choose_username') }}",
            searchInputPlaceholder: 'Enter username..',
            width: '100%',
            ajax: {
                url: '{{ route('users.findUser') }}',
                type: 'post',
                dataType: 'json',
                delay: 150,
                data: function (params) {
                    return {
                        _token: "{{ csrf_token() }}",
                        search: params.term
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    }
                },
                cache: true,
            }
        });
        $('.sumoSelect').SumoSelect();
    </script>
    @if(isset($data))
    <script>
        var newOption = new Option('{{ $data['user']['text'] }}', {{ $data['user']['id'] }}, true, true);
        $('.userSelect').append(newOption).trigger('change');
        $('.sumoSelect')[0].sumo.selectItem('{{ $data['week_num'] }}');
    </script>
    @endif
@endpush

