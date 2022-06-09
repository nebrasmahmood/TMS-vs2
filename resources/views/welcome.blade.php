@extends('layout.master')
@section('css-scripts')
    <link rel="stylesheet" href="{{ asset("assets/scss/widgets.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/css/index-pages.css") }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.15/dist/sweetalert2.min.css">
    <style>
        .card-group > .card{
            border: 0px;
            background-color: transparent;
        }
        .card-group > .card:first-child{
            padding-left: 0px;
        }
        .card-group > .card:last-child{
            padding-right: 0px;
        }
        .card-group > .card > .card-body{
            display: flex;
            flex-direction: row-reverse;
            justify-content: space-between;
            align-items: center;
        }
        .card-group > .card > .card-body > div:nth-child(2){
            flex: 50%;
        }
        .h4, h4 {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
        }
        .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
            color: #495057;
            background-color: #fff;
            border-color: #86c651 #86c651 #fff;
        }
        .nav-tabs {
            border-bottom: 1px solid #86c651;
        }
        .nav-tabs .nav-link:focus, .nav-tabs .nav-link:hover {
            border-color: #86c651 #86c651 #fff;
        }
        .post-text{
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            direction: ltr;
            min-height: calc(2*21.56px);
        }
    </style>
@endsection
@section('content')
    <!-- breadcrumbs -->
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>Dashboard</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumbs -->
    <div class="container-fluid">
        <div class="row m-0">
            <div class="col-sm-12">
                <div class="card-group">
                    <div class="card col-md-3 col-sm-6">
                        <div class="card-body bg-flat-color-2">
                            <div class="h1 text-muted text-right">
                                <i class="fa fa-users text-light"></i>
                            </div>
                            <div>
                                <div class="h4 mb-0 text-light">
                                    <span class="count">{{ $usersCount }}</span>
                                </div>
                                <small class="text-uppercase font-weight-bold text-light">Users</small>
                                <div class="progress progress-xs mt-3 mb-0 bg-light" style="width: 40%; height: 5px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card col-md-3 col-sm-6">
                        <div class="card-body bg-flat-color-3">
                            <div class="h1 text-right">
                                <i class="fa fa-map-marked-alt text-light"></i>
                            </div>
                            <div>
                                <div class="h4 mb-0 text-light">
                                    <span class="count">{{ $placesCount }}</span>
                                </div>
                                <small class="text-light text-uppercase font-weight-bold">Places</small>
                                <div class="progress progress-xs mt-3 mb-0 bg-light" style="width: 40%; height: 5px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card col-md-3 col-sm-6">
                        <div class="card-body bg-flat-color-5">
                            <div class="h1 text-right text-light">
                                <i class="fa fa-pie-chart"></i>
                            </div>
                            <div>
                                <div class="h4 mb-0 text-light">
                                    <span class="count">{{ $categoriesCount }}</span>
                                </div>
                                <small class="text-uppercase font-weight-bold text-light">Categories</small>
                                <div class="progress progress-xs mt-3 mb-0 bg-light" style="width: 40%; height: 5px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card col-md-3 col-sm-6">
                        <div class="card-body bg-flat-color-4">
                            <div class="h1 text-light text-right">
                                <i class="fa fa-file-alt"></i>
                            </div>
                            <div>
                                <div class="h4 mb-0 text-light">
                                    <span class="count">{{ $postsCount }}</span>
                                </div>
                                <small class="text-light text-uppercase font-weight-bold">Posts</small>
                                <div class="progress progress-xs mt-3 mb-0 bg-light" style="width: 40%; height: 5px;"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        @if(auth()->user()->role != 0)
            <div class="row m-0 mt-5">
                <div class="col-sm-12">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="users-tab" data-toggle="tab" href="#users" role="tab" aria-controls="home" aria-selected="true">Recent Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="places-tab" data-toggle="tab" href="#places" role="tab" aria-controls="places" aria-selected="false">Recent Places</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="cats-tab" data-toggle="tab" href="#cats" role="tab" aria-controls="cats" aria-selected="false">Recent Categories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="posts-tab" data-toggle="tab" href="#posts" role="tab" aria-controls="posts" aria-selected="false">Recent Posts</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="users" role="tabpanel" aria-labelledby="users-tab">
                            <h4 class="mt-3">Recent Users</h4>
                            <div class="table-responsive">
                                <table class="table table-striped" data-name="user">
                                    <thead>
                                    <tr class="table-head">
                                        <th scope="col">#</th>
                                        <th scope="col">{{ __("words.firstName") }}</th>
                                        <th scope="col">{{ __("words.lastName") }}</th>
                                        <th scope="col">{{ __("words.Email") }}</th>
                                        <th scope="col">{{ __("words.Role") }}</th>
                                        <th scope="col">{{ __("words.Bus Number") }}</th>
                                        <th scope="col">{{ __("words.Actions") }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (isset($recentUsers))
                                        @foreach($recentUsers as $user)
                                            <tr>
                                                <th scope="row">{{ $loop->index + 1 }}</th>
                                                <td>{{ $user->fname }}</td>
                                                <td>{{ $user->lname }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    @if($user->role == 2)
                                                        {{ __('words.super_admin') }}
                                                    @elseif($user->role == 1)
                                                        {{ __('words.admin') }}
                                                    @else
                                                        {{ __('words.user') }}
                                                    @endif
                                                </td>
                                                <td>{{ $user->busNo }}</td>
                                                <td>
                                                    <a href="{{ route('users.edit', $user->id) }}">
                                                        <i class="fa fa-edit text-primary"></i>
                                                    </a> |
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="post" class="delete-form">
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
                        </div>
                        <div class="tab-pane fade" id="places" role="tabpanel" aria-labelledby="places-tab">
                            <h4 class="mt-3">Recent Places</h4>
                            <div class="table-responsive">
                                <table class="table table-striped" data-name="place">
                                    <thead>
                                    <tr class="table-head">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Number</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (isset($recentPlaces))
                                        @foreach($recentPlaces as $place)
                                            <tr>
                                                <th scope="row">{{ $loop->index + 1 }}</th>
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
                        </div>
                        <div class="tab-pane fade" id="cats" role="tabpanel" aria-labelledby="cats-tab">
                            <h4 class="mt-3">Recent Categories</h4>
                            <div class="table-responsive">
                                <table class="table table-striped" data-name="category">
                                    <thead>
                                    <tr class="table-head">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (isset($recentCats))
                                        @foreach($recentCats as $cat)
                                            <tr>
                                                <th scope="row">{{ $loop->index + 1 }}</th>
                                                <td>{{ $cat->name }}</td>
                                                <td>{{ $cat->description }}</td>
                                                <td>{{ $cat->status == 1 ? 'Active' : 'Unactive' }}</td>
                                                <td>
                                                    <a href="{{ route('categories.edit', $cat->id) }}">
                                                        <i class="fa fa-edit text-primary"></i>
                                                    </a> |
                                                    <form action="{{ route('categories.destroy', $cat->id) }}" method="post" class="delete-form">
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
                        </div>
                        <div class="tab-pane fade" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                            <h4 class="mt-3">Recent Posts</h4>
                            <div class="table-responsive">
                                <table class="table table-striped" data-name="post">
                                    <thead>
                                    <tr class="table-head">
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Details</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (isset($recentPosts))
                                        @foreach($recentPosts as $post)
                                            <tr>
                                                <th scope="row">{{ $loop->index + 1 }}</th>
                                                <td>{{ $post->title }}</td>
                                                <td>{{ $post->category->name ?? '' }}</td>
                                                <td class="post-text">
                                                    @php
                                                        echo htmlspecialchars_decode(stripslashes($post->details))
                                                    @endphp
                                                </td>
                                                <td>
                                                    <a href="{{ route('posts.edit', $post->id) }}">
                                                        <i class="fa fa-edit text-primary"></i>
                                                    </a> |
                                                    <form action="{{ route('posts.destroy', $post->id) }}" method="post" class="delete-form">
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
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
@push('scripts')
    <script src="{{ asset("assets/js/widgets.js") }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.15/dist/sweetalert2.min.js"></script>
    <script>
        $(".fa-trash-alt").click(function(e){
            afterDeletionMsg = 'The ' + $(this).closest('table').data('name') +' has been deleted successfully.'
            let icon = this;
            e.preventDefault();
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-light ml-3'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'Are you sure to delete this?',
                text: "You won't be able to revert it after deletion!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    swalWithBootstrapButtons.fire({
                        showConfirmButton: false,
                        title: 'Deleted!',
                        text: afterDeletionMsg,
                        icon: 'success',
                    })
                    setTimeout(function(){
                        icon.closest('form').submit()
                    },500)
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    //    nothing
                }
            })
        })
    </script>
@endpush
