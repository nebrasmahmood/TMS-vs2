@extends("layout.master")
@section("css-scripts")
    <link href="{{ asset('assets/css/index-pages.css')}}" rel="stylesheet">
    <style>
        .table-bordered td, .table-bordered th {
            white-space: nowrap;
        }
        .h3, h3 {
            font-size: 1.4rem;
            margin: 1rem 0;
        }
    </style>
@endsection
@section('content')
    <!-- breadcrumbs -->
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>{{ __("nl-words.daily Jobs") }}</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li>
                            <a href="{{ url('/') }}">{{ __('nl-words.Home') }}</a>
                        </li>
                        <li class="">
                            <a href="{{ route('jobs.index') }}">{{ __("nl-words.Week Jobs") }}</a>
                        </li>
                        <li class="active">
                            <a href="{{ route('jobs.dailyJobs', Route::current()->parameter('date')) }}">{{ __("nl-words.daily Jobs") }}</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumbs -->
    <div class="container-fluid pr-0">
        <div class="row mr-0">
            <div class="col-12 pr-0">
                <h3>{{ date_format(date_create(Route::current()->parameter('date')), 'l') }} - {{ Route::current()->parameter('date') }}</h3>
                <div class="table-responsive pr-3">
                    <table class="table table-bordered mb-0">
                        <thead class="table-head">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Username</th>
                            <th scope="col">BusNo</th>
                            <th scope="col">Stops Number</th>
                            <th scope="col">Another Stops Number</th>
                            <th scope="col">Cube Number</th>
                            <th scope="col">Percentage</th>
                            <th scope="col">Notes</th>
{{--                            <th scope="col">Helper</th>--}}
                        </tr>
                        </thead>
                        <tbody>
                            <form id="updateForm" action="{{ route('jobs.updateAll') }}" method="post">
                                @csrf()
                                @method('put')
                                @foreach($jobs as $job)
                                    <input type="hidden" name="" />
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td>{{ $job->user->name }}</td>
                                        <td>{{ $job->user->busNo }}</td>
                                        <td>
                                            <input type="number" id="job-{{ $job->id }}-stops_no" name="jobs[{{ $job->id }}][stops_no]" value="{{ old("jobs." . $job->id . ".stops_no", $job->stops_no) }}" placeholder="Enter stops number.." class="form-control is-valid @error("jobs." . $job->id . ".stops_no")is-invalid @enderror">
                                            @error("jobs." . $job->id . ".stops_no")
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="number" id="job-{{ $job->id }}-AnotherstopsNo" name="jobs[{{ $job->id }}][AnotherstopsNo]" value="{{ old("jobs." . $job->id . ".AnotherstopsNo", $job->AnotherstopsNo) }}" placeholder="Enter another stops number.." class="form-control is-valid @error("jobs." . $job->id . ".AnotherstopsNo")is-invalid @enderror">
                                            @error("jobs." . $job->id . ".AnotherstopsNo")
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="number" id="job-{{ $job->id }}-cube_no" name="jobs[{{ $job->id }}][cube_no]" value="{{ old("jobs." . $job->id . ".cube_no", $job->cube_no) }}" placeholder="Enter cube number.." class="form-control is-valid @error("jobs." . $job->id . ".cube_no")is-invalid @enderror">
                                            @error("jobs." . $job->id . ".cube_no")
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="number" id="job-{{ $job->id }}-percentage" name="jobs[{{ $job->id }}][percentage]" value="{{ old("jobs." . $job->id . ".percentage", $job->percentage) }}" placeholder="Enter percentage.." class="form-control is-valid @error("jobs." . $job->id . ".percentage")is-invalid @enderror">
                                            @error("jobs." . $job->id . ".percentage")
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                        <td>
                                            <textarea id="job-{{ $job->id }}-notes" name="jobs[{{ $job->id }}][notes]" placeholder="Enter Notes.." rows="1" class="form-control is-valid @error("jobs." . $job->id . ".notes")is-invalid @enderror">{{ old("jobs." . $job->id . ".notes", $job->notes) }}</textarea>
                                            @error("jobs." . $job->id . ".notes")
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </td>
                                    </tr>
                                @endforeach
                            </form>
                        </tbody>
                    </table>
                    <div>
                        <button type="submit" class="btn btn-success mt-3" onclick="$('#updateForm').submit();">Approve</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('/assets/js/select2.min.js')}}"></script>
    <script>
        $('.helperSelect').select2({
            placeholder: "{{ __('nl-words.choose_jobname') }}",
            language: "ar",
            searchInputPlaceholder: 'Enter jobname..',
            @error('helper_id')
            dropdownCssClass : 'error',
            selectionCssClass: 'error',
            @enderror
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
    </script>
@endpush
