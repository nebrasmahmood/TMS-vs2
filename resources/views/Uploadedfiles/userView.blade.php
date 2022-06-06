@extends("layout.master")
@section("css-scripts")
    <link href="{{ asset('assets/css/paginator.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/index-pages.css')}}" rel="stylesheet">
    <style>
        .file_path{
            text-decoration: underline;
            outline: none !important;
            color: #0234c6;
        }
    </style>
@endsection
@section("content")
    <!-- breadcrumbs -->
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>{{ __("words.Uploaded_files") }}</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li>
                            <a href="{{ url('/') }}">{{ __('words.Home') }}</a>
                        </li>
                        <li class="active">
                            <a href="{{ route('uploadfiles.index') }}">{{ __("words.Uploaded_files") }}</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumbs -->
    <div class="col-lg-12 table-card">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr class="table-head">
                            <th scope="col">#</th>
                            <th scope="col">{{ __("words.file_name") }}</th>
                            <th scope="col">{{ __("words.file_path") }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (isset($files))
                            @foreach($files as $file)
                                <tr>
                                    <th scope="row">{{ number_format(($files->currentPage() - 1) * $files->perPage() + $loop->index + 1) }}</th>
                                    <td>{{ $file->file_name }}</td>
                                    <td>
                                        <a href="{{ url('/') . "/" . $file->file_path }}" class="file_path">{{ explode('/', $file->file_path)[2] }}</a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                {{ $files->onEachSide(2)->links('vendor.pagination.myPaginator') }}
            </div>
        </div>
    </div>
@endsection
