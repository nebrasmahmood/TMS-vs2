@extends("layout.master")
@section("css-scripts")
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.15/dist/sweetalert2.min.css">
    <link href="{{ asset('assets/css/paginator.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/index-pages.css')}}" rel="stylesheet">
@endsection
@section("content")
    <!-- breadcrumbs -->
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>{{ __("nl-words.place") }}</h1>
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
                            <a href="{{ route('places.index') }}">{{ __("nl-words.Places") }}</a>
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
                <a href="{{ route('places.create') }}" class="btn btn-success text-white" role="button">{{ __("nl-words.Add Place") }}</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr class="table-head">
                            <th scope="col">#</th>
                            <th scope="col">{{ __("nl-words.Name") }}</th>
                            <th scope="col">{{ __("nl-words.Number") }}</th>
                            <th scope="col">{{ __("nl-words.Actions") }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (isset($places))
                            @foreach($places as $place)
                            <tr>
                                <th scope="row">{{ number_format(($places->currentPage() - 1) * $places->perPage() + $loop->index + 1) }}</th>
                                <td>{{ $place->name }}</td>
                                <td>{{ $place->number }}</td>
                                <td>
                                    <a href="{{ route('places.edit', $place->id) }}">
                                        <i class="fa fa-edit text-primary"></i>
                                    </a> |
                                    <form action="{{ route('places.destroy', $place->id) }}" method="post" class="delete-form">
                                        @csrf
                                        @method('delete')
                                        <i class="far fa-trash-alt text-danger"></i>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                {{ $places->onEachSide(2)->links('vendor.pagination.myPaginator') }}
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.15/dist/sweetalert2.min.js"></script>
    <script>
        var afterDeletionMsg = 'The place has been deleted successfully.'
    </script>
    <script src="{{ asset('assets/js/sweetalert-deletion.js') }}"></script>
@endpush
