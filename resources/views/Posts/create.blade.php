@extends("layout.master")
@section("css-scripts")
    <link rel="stylesheet" href="{{ asset('assets/css/create-pages.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom-switch.css') }}">
    <link href="{{ asset('assets/css/select2.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.css') }}">
    <script src="{{ asset('assets/js/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <style>
        .images {
            display: flex;
            flex-wrap:  wrap;
        }
        .images .img,
        .images .pic {
            flex-basis: 31%;
            margin-bottom: 10px;
            border-radius: 4px;
        }
        .images .img {
            width: 140px;
            height: 130px;
            background-size: cover;
            margin-right: 10px;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            border: 1px solid #28a745 !important;
        }
        .images .img:nth-child(3n) {
            margin-right: 0;
        }
        .images .img span {
            display: none;
            text-transform: capitalize;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            z-index: 2;
        }
        .images .img::after {
            content: '';
            width: 100%;
            height: 100%;
            transition: opacity .1s ease-in;
            border-radius: 4px;
            opacity: 0;
            position: absolute;
        }
        .images .img:hover::after {
            display: block;
            background-color: #000;
            opacity: .5;
        }
        .images .img:hover span {
            display: flex;
            color: #fff;
        }
        .images .pic {
            width: 140px;
            height: 130px;
            background-color: #ffffff;
            align-self: center;
            text-align: center;
            padding: 40px 0;
            text-transform: uppercase;
            color: #848EA1;
            font-size: 12px;
            cursor: pointer;
            border: 1px solid #28a745 !important;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .img-icon{
            font-size: 25px;
            color: #868e96;
            margin-bottom: 0.3rem;
        }

        .remove-img-icon{

        }
        @media screen and (max-width: 400px) {
            .images .img,
            .images .pic {
                flex-basis: 100%;
                margin-right: 0;
            }
        }

        .images.is-invalid .pic,
        .images.is-invalid .img{
            border: 1px solid #dc3545 !important;
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
                        <li>
                            <a href="{{ route('posts.index') }}">{{ __('nl-words.posts') }}</a>
                        </li>
                        <li class="active">
                            <a href="{{ route('posts.create') }}">{{ __('nl-words.create_post') }}</a>
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
                <h1>{{ __('nl-words.Add_new_post') }}</h1>
            </div>
            <div class="card-body card-block">
                <form action="{{ route('posts.store') }}" method="post" class="" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="title" class="form-control-label">{{ __('nl-words.Title') }}</label>
                                <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="{{ __('nl-words.Enter_post_title') }}" class="form-control is-valid @error('title')is-invalid @enderror">
                            </div>
                            @error("title")
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="category_id" class="form-control-label">{{ __('nl-words.category') }}</label>
                                <select class="form-control categorySelect @error('category_id')is-invalid @enderror" id="category_id" name="category_id">
                                    <option value="0" selected>{{ __('nl-words.choose_category') }}</option>
                                </select>
                            </div>
                            @error("category_id")
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="upload-img-input" class="form-control-label">{{ __('nl-words.post_image') }}</label>
                                <div class="images @error("image") is-invalid @enderror">
                                    <input style="display: none !important;" id="upload-img-input" name="image" type="file" accept="image/png, image/jpg, image/jpeg" />
                                    <div class="pic">
                                        <i class="fa fa-image img-icon"></i>
                                        add image
                                    </div>
                                </div>
                            </div>
                            @error("image")
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="details" class=" form-control-label">{{ __('nl-words.details') }}<span class="text-muted">(optional)</span></label>
                                <textarea id="details" name="details" placeholder="{{ __('nl-words.details_placeholder') }}" class="form-control is-valid @error('details')is-invalid @enderror">{{ old('details') }}</textarea>
                                <div id="character_count"></div>
                            </div>
                            @error("details")
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="form-group custom-switch">
                                <label class="">{{ __('nl-words.Status') }}</label>
                                <input type="checkbox" class="custom-switch-input checkbox" id="customSwitch1" name="status" value="1" {{ old('status') == 1 ? 'checked' : '' }}>
                                <label class="custom-switch-label" for="customSwitch1" data-before="Unactive"></label>
                            </div>
                            @error("status")
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success submit-btn">{{ __('nl-words.Save_post') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('/assets/js/select2.min.js')}}"></script>
    <script>
        $(".checkbox").change(function() {
            if(this.checked) {
                $('label.custom-switch-label').attr('data-before','Active');
            }else{
                $('label.custom-switch-label').attr('data-before','Unactive');
            }
        });
    </script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'preview importcss searchreplace autolink save directionality visualblocks visualchars fullscreen link charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount charmap quickbars emoticons',
            menubar: 'file edit view insert format',
            toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen preview save print | link anchor codesample | ltr rtl',
            tinycomments_mode: 'embedded',
            quickbars_insert_toolbar: '',
            autosave_interval: '30s',
        });

        $('.categorySelect').select2({
            placeholder: "{{ __('words.choose_category') }}",
            searchInputPlaceholder: 'Enter category name..',
            width: '100%',
            @error('category_id')
            dropdownCssClass : 'error',
            selectionCssClass: 'error',
            @enderror
            ajax: {
                url: '{{ route('categories.findCategory') }}',
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

    <script>
        (function ($) {
            $(document).ready(function () {
                uploadImage()
                function uploadImage() {
                    var button = $('.images .pic')
                    var uploader = $('#upload-img-input')
                    var images = $('.images')

                    button.on('click', function () {
                        uploader.click()
                    })

                    uploader.on('change', function () {
                        var reader = new FileReader()
                        reader.onload = function(event) {
                            images.prepend(`<div class="img" style="background-image: url(\ ${event.target.result}\ );" rel=" ${event.target.result} "><span><i class="fa fa-times remove-img-icon"></i>remove</span></div>`)
                        }
                        reader.readAsDataURL(uploader[0].files[0])
                        button.css('display', 'none')
                    })

                    images.on('click', '.img', function () {
                        $(this).remove();
                        button.css('display', 'flex')
                    })

                }
            })
        })(jQuery);
    </script>
@endpush
