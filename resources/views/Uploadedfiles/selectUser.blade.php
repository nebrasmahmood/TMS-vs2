@extends("layout.master")
@section("css-scripts")
    <link href="{{ asset('assets/css/paginator.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/index-pages.css')}}" rel="stylesheet">
    <style>
        .btn-primary{
            background-color: #02a4e1 !important;
            border-color: #0397cf !important;;
        }
    </style>
@endsection
@section("content")
    <!-- breadcrumbs -->
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>{{ __('words.Uploaded_files') }}</h1>
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
                            <a href="{{ route('uploadfiles.selectUsers') }}">{{ __('words.selectUsers') }}</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumbs -->
    <div class="col-lg-12 table-card">
        <div class="card">
            <div class="card-header p-0">
{{--                <a href="{{ route('uploaded-files.create') }}" class="btn btn-success text-white" role="button">{{ __('words.Add file') }}</a>--}}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr class="table-head">
                            <th scope="col">#</th>
                            <th scope="col">{{ __('words.firstName') }}</th>
                            <th scope="col">{{ __('words.lastName') }}</th>
                            <th scope="col">{{ __('words.upload_file') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (isset($users))
                            @foreach($users as $user)
                                <tr>
                                    <th scope="row">{{ number_format(($users->currentPage() - 1) * $users->perPage() + $loop->index + 1) }}</th>
                                    <td>{{ $user->fname }}</td>
                                    <td>{{ $user->lname }}</td>
                                    <td>
                                        <a href="{{ route('uploadfiles.uploadTouser', $user->id) }}" class="btn btn-primary" role="button">
                                            <i class="fa fa-file-arrow-up text-white"></i> {{ __('words.upload_file') }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                {{ $users->onEachSide(2)->links('vendor.pagination.myPaginator') }}
            </div>
        </div>
    </div>
@endsection
@push('scripts')
@endpush
