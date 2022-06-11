@extends("layout.master")
@section("css-scripts")
    <link href="{{ asset('assets/css/index-pages.css')}}" rel="stylesheet">
    <style>
        th{
            background-color: #02a4e1 !important;
            color: white;
        }
        .h3, h3 {
            font-size: 1.3rem;
            text-align: left;
        }
        #no-jobs-div{
            padding: 6rem 0;
            text-align: center;
            text-transform: uppercase;
            font-size: 1.2rem;
        }
    </style>
@endsection
@section("content")
    <!-- breadcrumbs -->
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>{{ __('words.Jobs') }}</h1>
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
                            <a href="{{ route('jobs.dayJobs') }}">{{ __('words.daily Jobs') }}</a>
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
                <h3>Jobs Of Day {{ date_format(date_create(), 'l') }} - {{ date('Y-m-d') }}</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody>
                        @if (isset($job))
                            <tr>
                                <th scope="row">{{ __('words.place') }}</th>
                                <td>{{ $job->place->name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">{{ __('words.busNo') }}</th>
                                <td>{{ $job->user->busNo ?? '' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">{{ __('words.another_stops_no') }}</th>
                                <td>{{ $job->AnotherstopsNo }}</td>
                            </tr>
                            <tr>
                                <th scope="row">{{ __('words.cube_no') }}</th>
                                <td>{{ $job->cube_no }}</td>
                            </tr>
                            <tr>
                                <th scope="row">{{ __('words.percentage') }}</th>
                                <td>{{ $job->percentage }}</td>
                            </tr>
                            <tr>
                                <th scope="row">{{ __('words.notes') }}</th>
                                <td>{{ $job->notes }}</td>
                            </tr>
                        @else
                            <tr>
                                <td>
                                    <div id="no-jobs-div">No Jobs For Today</div>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
@endpush
