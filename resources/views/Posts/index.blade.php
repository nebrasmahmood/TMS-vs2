@extends("layout.master")
@section("css-scripts")
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.15/dist/sweetalert2.min.css">
    <link href="{{ asset('assets/css/paginator.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/index-pages.css')}}" rel="stylesheet">
    <style>
        p{
            margin-bottom: 0px;
        }
        .card-text{
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            direction: ltr;
            min-height: calc(2*21.56px);
        }
        .dots-btn{
            padding: 10px;
            position: absolute;
            right: 15px;
            top: 15px;
            background-color: transparent;
            height: 24px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .dropdown-toggle::after {
            display: none !important;
        }
        .card-body{
            position: relative;
        }
        .card-deck > div{
            padding: 0px;
        }
        .card-deck .dropdown-menu.show {
            border: 1px solid #cdcdcd !important;
            top: 40px !important;
            right: 0px !important;
            left: auto !important;
            will-change: transform !important;
            padding: 0px;
        }
        .dropdown-item{
            padding: 8px 15px;
        }
        .card-img-top{
            height: 300px;
            object-fit: cover;
        }

        @media only screen and (max-width: 768px) and (min-width: 576px){
            .card-deck > div{
                margin-top: 30px;
            }
            .card-deck > div:nth-child(1){
                margin-top: 0px;
            }
        }
        @media only screen and (max-width: 992px) and (min-width: 768px){
            .card-deck > div{
                margin-top: 30px;
            }
            .card-deck > div:nth-child(1),
            .card-deck > div:nth-child(2){
                margin-top: 0px;
            }
        }
        .no-posts-div{
            width: 100%;
            height: calc(100vh - 270px);
            background-color: #f3f3f3;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .no-posts-div > p{
            font-size: 20px;
            letter-spacing: 1px;
            text-transform: uppercase;
            text-align: center;
        }
    </style>
    <style>
        input[type="radio"]{
            appearance: none;
            border: 1px solid #d3d3d3;
            width: 20px;
            height: 20px;
            content: none;
            outline: none;
            margin: 0;
        }

        input[type="radio"]:checked {
            appearance: none;
            outline: none;
            padding: 0;
            content: none;
            border: none;
        }

        input[type="radio"]:checked::before{
            position: absolute;
            color: #02a4e1 !important;
            content: "\00A0\2713\00A0" !important;
            border: 1px solid #d3d3d3;
            font-weight: bolder;
            font-size: 13px;
            width: 20px;
            height: 20px;
        }
        .form-check-label{
            margin-left: 0.5rem;
        }
        .form-group{
            display: flex;
            align-items: center;
            margin-bottom: .5rem;
        }
    </style>
@endsection
@section("content")
    <!-- breadcrumbs -->
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>{{ __('nl-words.posts') }}</h1>
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
                            <a href="{{ route('posts.index') }}">{{ __('nl-words.posts') }}</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumbs -->
    <div class="col-lg-12 table-card">
        <div class="card">
            @if(auth()->user()->role != 0)
            <div class="card-header">
                <a href="{{ route('posts.create') }}" class="btn btn-success text-white" role="button">{{ __('nl-words.Add post') }}</a>
            </div>
            @endif
            <div class="card-body container-fluid">
                <div class="row m-0">
                    <div class="col-md-10">
                        <div class="card-deck row">
                            @forelse ($posts as $post)
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="card">
                                        <img class="card-img-top" src="{{ $post->post_img ? asset($post->post_img) : asset('images/no-image.jpg') }}" alt="Post image">
                                        <div class="card-body">
                                            <button type="button" class="btn dots-btn dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference{{ $post->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="10,0" data-reference="self">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuReference{{ $post->id }}">
                                                <a class="dropdown-item show-btn text-success" href="{{ route('posts.show', $post->id) }}"><i class="fas fa-eye"></i> {{ __("nl-words.show") }}</a>
                                                @if(auth()->user()->role != 0)
                                                <a class="dropdown-item edit-btn text-primary" href="{{ route('posts.edit', $post->id) }}"><i class="fas fa-edit"></i> {{ __("nl-words.edit") }}</a>
                                                <form method="post" action="{{ route('posts.destroy', $post->id) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <a class="dropdown-item delete-btn text-danger" onclick="$(this).closest('form').submit()"><i class="far fa-trash-alt text-danger"></i> {{ __("nl-words.delete") }}</a>
                                                </form>
                                                @endif
                                            </div>
                                            <h5 class="card-title">{{ $post->title }}</h5>
                                            <div class="card-text">
                                                @php
                                                    echo htmlspecialchars_decode(stripslashes($post->details))
                                                @endphp
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <small class="text-muted">Last updated {{ $diff = Carbon\Carbon::parse($post->updated_at)->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="no-posts-div">
                                    <p>No POSTS :(</p>
                                </div>
                            @endforelse
                        </div>
                        {{ $posts->onEachSide(2)->links('vendor.pagination.myPaginator') }}
                    </div>
                    <div class="col-md-2" style="border-left: 1px solid #e0e0e0;">
                        <h4 style="margin-bottom: 1rem;">{{ __('words.categories') }}</h4>
                        <form action="{{ route('posts.index') }}" method="get">
                            @foreach($cats as $cat)
                                <div class="form-group">
                                    <input type="radio" class="radio-btn" name="category_id" id="radio{{ $cat->id }}" value="{{ $cat->id }}" {{ request()->query('category_id') == $cat->id ? 'checked' : '' }}>
                                    <label class="form-check-label" for="radio{{ $cat->id }}">
                                        {{ $cat->name }}
                                    </label>
                                </div>
                            @endforeach
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(".radio-btn").change(function(){
            $(this).closest('form').submit();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.15/dist/sweetalert2.min.js"></script>
    <script>
        var afterDeletionMsg = 'The post has been deleted successfully.'
    </script>
    <script src="{{ asset('assets/js/sweetalert-deletion.js') }}"></script>
@endpush
