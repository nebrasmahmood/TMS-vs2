@extends("layout.master")
@section("css-scripts")
    <link href="{{ asset('assets/css/index-pages.css')}}" rel="stylesheet">
    <style>
        p{
            margin-bottom: 0px;
        }
        .card-text{
            /*display: -webkit-box;*/
            /*-webkit-line-clamp: 2;*/
            /*-webkit-box-orient: vertical;*/
            /*overflow: hidden;*/
            /*text-overflow: ellipsis;*/
            direction: ltr;
            /*min-height: calc(2*21.56px);*/
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
            object-fit: none;
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
            <div class="card-body container-fluid">
                <div class="card">
                    <img class="card-img-top" src="{{ $post->post_img ? asset($post->post_img) : asset('images/no-image.png') }}" alt="Post image">
                    <div class="card-body">
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
        </div>
    </div>
@endsection
