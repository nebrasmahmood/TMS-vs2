@extends("layout.master")
@section("css-scripts")
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.15/dist/sweetalert2.min.css">
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
            <div class="card-header">
                <a href="{{ route('uploadfiles.selectUsers') }}" class="btn btn-success text-white" role="button">{{ __("words.choose User") }}</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr class="table-head">
                            <th scope="col">#</th>
                            <th scope="col">{{ __("words.user_fullName") }}</th>
                            <th scope="col">{{ __("words.file_name") }}</th>
                            <th scope="col">{{ __("words.file_path") }}</th>
                            <th scope="col">{{ __("words.Actions") }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (isset($files))
                            @foreach($files as $file)
                            <tr>
                                <th scope="row">{{ number_format(($files->currentPage() - 1) * $files->perPage() + $loop->index + 1) }}</th>
                                <td>{{ $file->user->name }}</td>
                                <td>{{ $file->file_name }}</td>
                                <td>
                                    <a href="{{ url('/') . "/" . $file->file_path }}" class="file_path">{{ explode('/', $file->file_path)[2] }}</a>
                                </td>
                                <td>
                                    <form action="{{ route('uploadfiles.destroy', $file->id) }}" method="post" class="delete-form">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger" onclick="fireswal()"><i class="far fa-trash-alt text-white"></i> Delete</button>
                                    </form>
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
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.15/dist/sweetalert2.min.js"></script>
    <script>
        var afterDeletionMsg = 'The user has been deleted successfully.'
        function fireswal(e){
            $(this).find('i.fa-trash-alt').click();
        }
    </script>
    <script src="{{ asset('assets/js/sweetalert-deletion.js') }}"></script>
@endpush
