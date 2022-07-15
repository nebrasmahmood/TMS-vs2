@extends("layout.master")
@section("css-scripts")
    <link rel="stylesheet" href="{{ asset('assets/css/create-pages.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom-switch.css') }}">
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
                    <h1>{{ __('nl-words.upload_file') }}</h1>
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
                            <a href="{{ route('uploadfiles.selectUsers') }}">{{ __('nl-words.Select User') }}</a>
                        </li>
                        <li class="active">
                            <a href="{{ route('uploadfiles.uploadTouser', $user_id) }}">{{ __('nl-words.uploadTouser') }}</a>
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
                <h1>{{ __('nl-words.uploadTouser') }}</h1>
            </div>
            <div class="card-body card-block">
                <form action="{{ route('uploadfiles.upload', $user_id) }}" method="post" class="" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="file_name" class="form-control-label">{{ __('nl-words.file_name') }}</label>
                                <input type="text" id="file_name" name="file_name" value="{{ old('file_name') }}" placeholder="{{ __('nl-words.Enter_file_name') }}" class="form-control is-valid @error('file_name')is-invalid @enderror">
                            </div>
                            @error("file_name")
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="upload-img-input" class="form-control-label">{{ __('words.file') }}</label>
                                <div class="images @error("image") is-invalid @enderror">
                                    <input style="display: none !important;" id="upload-img-input" name="file" type="file" accept="application/pdf" />
                                    <div class="pic">
                                        <i class="fa fa-file-circle-plus img-icon"></i>
                                        add file
                                    </div>
                                </div>
                            </div>
                            @error("image")
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row" style="margin-top: 0px !important;">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success submit-btn">{{ __('nl-words.upload_file') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
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
                            pdf_icon = '{{ asset('images/pdf.png') }}'
                            images.prepend(`<div class="img" style="background-image: url(${pdf_icon});background-size: 80px;background-repeat: no-repeat;" rel=" ${event.target.result} "><span><i class="fa fa-times remove-img-icon"></i>remove</span></div>`)
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
