@extends('layout.master')
@section('css-scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link href="{{ asset('assets/css/index-pages.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.15/dist/sweetalert2.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/fullcalendar-main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fullcalendar.css') }}">
    <link href="{{ asset('assets/css/select2.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-timepicker.min.css') }}" />
    <style>
        .text-muted{
            margin-left: 6px;
            font-size: 80%;
        }
        .row{
            margin: 0px;
        }
        thead th, tbody th, tbody td {
            vertical-align: middle !important;
            text-align: center !important;
        }
        .table th, .table td {
            padding: 0.5rem;
        }
        #groups .table thead th {
            font-size: 18px;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        .fs-22 {
            font-size: 22px;
            color: #ddd;
        }

        .time-input, .end-time {
            direction: ltr;
            text-align: left;
        }

        .days {
            font-size: 16px;
        }

        #groups table .SumoSelect .CaptionCont {
            display: flex;
        }

        #modal-alert {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-direction: row-reverse;
        }

        #modal-alert button {
            color: white;
            opacity: 1;
            font-size: 20px;
        }

        input.form-control.time-input.start-time.invalid-feedback {
            border: 1px red solid;
        }

        input.form-control.time-input.start-time.invalid-feedback::placeholder {
            color: red;
        }

        .input-group > .input-group-prepend > .input-group-text{
            background-color: lightgray;
            color: black;
        }
        .time-input-group{
            direction: ltr;
            padding: 4px;
        }
        .searchRow button{
            margin-bottom: 1rem;
            border-radius: 0.25rem;
            width: 100%;
        }
        .searchRow .col-1{
            display: flex;
            justify-content: center;
            align-items: end;
            padding-right: 0px;
        }
        .modal .placeDiv .select2 .select2-selection__placeholder,
        .modal .busDiv .select2 .select2-selection__placeholder{
            color: #495057 !important;
        }
        .form-control:disabled, .form-control[readonly] {
            background-color: #ffffff;
            opacity: 1;
        }
        .btn-outline-primary{
            background-color: #02a4e1 !important;
            border-color: #02a4e1 !important;
            color: white;
        }
        .search-btn{
            border-bottom: 2px solid transparent !important;
        }
        .modal .btn-primary:hover,
        .search-btn:hover
        {
            border-color: #028abe !important;
            background-color: #028abe !important;
            color: white !important;
            font-weight: 400;
            border-bottom: 2px solid transparent;
        }
        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: -0.7rem;
            margin-bottom: 0.5rem;
        }
    </style>
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>{{ __('words.Events') }}</h1>
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
                            <a href="{{ route('events.index') }}">{{ __('words.Events') }}</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumbs -->
    <!-- row opened -->
    <div class="row">
        <!--div-->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    @if(auth()->user()->role != 0)
                        <div class="row">
                            <div class="col-12 p-0">
                                <form action="{{ route('events.index') }}" method="get">
                                    <div class="row searchRow">
                                        <div class="col-11 pl-0">
                                            <div class="form-group">
                                                <label for="user_id" class="form-control-label">{{ __('words.User') }}</label>
                                                <select class="form-control userSelect @error('user_id')is-invalid @enderror" id="user_id" name="user_id">
                                                    <option value="0" selected>{{ __('words.choose_username') }}</option>
                                                </select>
                                            </div>
                                            @error("user_id")
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-1">
                                            <button class="btn btn-outline-primary search-btn" type="submit">{{ __("words.search") }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-lg-9 col-md-12 pl-0">
                            <div class="main-content-body main-content-body-calendar card p-4">
                                <div class="main-calendar" id="calendar"></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 p-0">
                            <div class=" card card--calendar p-0 mg-b-20">
                                <div class="card-body" style="padding: 1.5rem 0.5rem;">
                                    <form action="{{ route('events.store') }}" method="post" class="">
                                        @csrf
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="title" class="form-control-label">{{ __('words.Title') }}</label>
                                                    <input type="text" name="title" placeholder="{{ __('words.title_placeholder') }}" class="form-control is-valid @error('title')is-invalid @enderror" id="title" @if(isset($event)) value="{{ old('title', $event->title) }}" @else value="{{ old('title') }}" @endif required>
                                                </div>
                                                @error("title")
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="place_id" class="form-control-label">{{ __('words.Place') }}</label>
                                                    <select class="form-control placeSelect @error('place_id')is-invalid @enderror" id="form_place_id" name="place_id">
                                                        <option value="0" selected>{{ __('words.choose_place') }}</option>
                                                    </select>
                                                </div>
                                                @error("place_id")
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="busNo" class="form-control-label">{{ __('words.busNo') }}</label>
                                                    <select class="form-control busSelect @error('busNo')is-invalid @enderror" id="form_busNo" name="busNo">
                                                        <option value="0" selected>{{ __('words.choose_busNo') }}</option>
                                                    </select>
                                                </div>
                                                @error("busNo")
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="start_km" class="form-control-label">{{ __('words.start_km') }}</label>
                                                    <input type="number" @if(isset($event)) value="{{ old('start_km', $event->start_km) }}" @endif placeholder="{{ __('words.enter_start_km') }}" class="form-control is-valid @error('start_km')is-invalid @enderror" id="start_km" name="start_km">
                                                </div>
                                                @error("start_km")
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="end_km" class="form-control-label">{{ __('words.end_km') }}</label>
                                                    <input type="number" @if(isset($event)) value="{{ old('end_km', $event->end_km) }}" @endif placeholder="{{ __('words.enter_end_km') }}" class="form-control is-valid @error('end_km')is-invalid @enderror" id="end_km" name="end_km">
                                                </div>
                                                @error("end_km")
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="date" class="form-control-label">{{ __('words.Date') }}<span class="d-inline text-muted">(YYYY-MM-DD)</span></label>
                                                    <input type="text" id="date" name="date" value="{{ old('date') }}" placeholder="Enter date.." class="form-control datepicker is-valid @error('date')is-invalid @enderror" autocomplete="off" required>
                                                </div>
                                                @error("date")
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="start" class="form-control-label">{{ __('words.Start_time') }}<span class="d-inline text-muted">(HH:mm)</span></label>
                                                    <input type="text" name="start" id="start" value="{{ old('start') }}" placeholder="{{ __('words.start_placeholder') }}"
                                                           class="form-control is-valid time-input start-time" autocomplete="off" required>
                                                </div>
                                                @error("start")
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="end" class="form-control-label">{{ __('words.End_time') }}<span class="d-inline text-muted">(HH:mm)</span></label>
                                                    <input type="text" name="end" id="end" value="{{ old('end') }}" placeholder="{{ __('words.end_placeholder') }}"
                                                           class="form-control is-valid time-input end-time" autocomplete="off" required>
                                                </div>
                                                @error("end")
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="stopsNum" class="form-control-label">{{ __('words.stopsNum') }}</label>
                                                    <input type="number" @if(isset($event)) value="{{ old('stopsNum', $event->stopsNum) }}" @else value="{{ old('stopsNum') }}" @endif placeholder="{{ __('words.stopsNum_placeholder') }}" class="form-control is-valid @error('stopsNum')is-invalid @enderror" id="stopsNum" name="stopsNum">
                                                </div>
                                                @error("stopsNum")
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <button type="submit" class="btn btn-block btn-success submit-btn" {{ auth()->user()->role != 0 ? 'disabled' : '' }}>{{ __('words.save') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->
    </div>
    <!-- /row -->
    <div class="modal" id="add-event-modal">
        <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{ __('words.event_details') }}</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body p-0">
                    <form class="">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="title" class="form-control-label">{{ __('words.Title') }}</label>
                                    <input type="text" class="form-control is-valid" id="title" disabled>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group placeDiv">
                                    <label for="place_id" class="form-control-label">{{ __('words.Place') }}</label>
                                    <select class="form-control placeSelect @error('place_id')is-invalid @enderror" id="place_id" disabled>
                                        <option id="placeOption" value="" selected></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group busDiv">
                                    <label for="busNo" class="form-control-label">{{ __('words.busNo') }}</label>
                                    <select class="form-control busSelect" id="busNo" disabled>
                                        <option value="" selected></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="start_km" class="form-control-label">{{ __('words.start_km') }}</label>
                                    <input type="number" placeholder="" class="form-control is-valid" id="start_km" disabled>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="end_km" class="form-control-label">{{ __('words.end_km') }}</label>
                                    <input type="number" placeholder="" class="form-control is-valid" id="end_km" disabled>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="date" class="form-control-label">{{ __('words.Date') }}<span class="d-inline text-muted">(YYYY-MM-DD)</span></label>
                                    <input type="text" id="date" value="" placeholder="" class="form-control datepicker is-valid" autocomplete="off" disabled>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="start" class="form-control-label">{{ __('words.Start_time') }}<span class="d-inline text-muted">(HH:mm)</span></label>
                                    <input type="text" id="start" placeholder=""
                                           class="form-control is-valid time-input start-time" autocomplete="off" disabled>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="end" class="form-control-label">{{ __('words.End_time') }}<span class="d-inline text-muted">(HH:mm)</span></label>
                                    <input type="text" id="end" placeholder=""
                                           class="form-control is-valid time-input end-time" autocomplete="off" disabled>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="stopsNum" class="form-control-label">{{ __('words.stopsNum') }}</label>
                                    <input type="number" placeholder="" class="form-control is-valid" id="stopsNum" disabled>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    @if(auth()->user()->role != 0)
                        <a href="" class="btn btn-primary modal-edit-btn">Edit</a>
                        <form id="modal-delete-btn" method="post" action="">
                            @csrf()
                            @method('delete')
                            <button type="button" class="btn btn-danger"><i class="fa fa-trash-alt" style="display: none !important;"></i>Delete</button>
                        </form>
                    @endif
                    <button class="btn ripple btn-success" aria-label="Close" data-dismiss="modal"
                            type="button" id="submit_form">{{ __('words.Close') }}</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        // $(".submit-btn:not(:disabled)").on("click", function(e){
        //     e.preventDefault();
        //     let date = $("#date").val();
        //     let startTime = $("#start").val();
        //     let endTime = $("#end").val();
        //     startTime = startTime ? changeTimeFormat(startTime) : "00:00:00";
        //     endTime = endTime ? changeTimeFormat(endTime) : "00:00:00";
        //
        //     $("#start").val(date + " " + startTime);
        //     $("#end").val(date + " " + endTime);
        // });
        window.days = ["{{ __('words.saturday') }}", "{{ __('words.sunday') }}", "{{ __('words.monday') }}", "{{ __('words.tuesday') }}", "{{ __('words.wednesday') }}", "{{ __('words.thersday') }}", "{{ __('words.friday') }}"];
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.15/dist/sweetalert2.min.js"></script>
    <script src="{{ asset('assets/js/fullcalendar-main.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ asset('assets/js/bootstrap-timepicker.js') }}"></script>
    <script src="{{ asset('/assets/js/select2.min.js')}}"></script>
    <script>
        var afterDeletionMsg = 'The event has been deleted successfully.'
        var hasOpenedModal = true;
        var modalId = 'add-event-modal';
    </script>
    <script src="{{ asset('assets/js/sweetalert-deletion.js') }}"></script>
    <script>
        var events = {};
        @if(isset($user_id))
            var events = {
                id: 1,
                backgroundColor: '#86c651',
                borderColor: '#86c651',
                textColor: '#fff',
                url: '{{ route('events.getEvents', $user_id) }}',
            };
        @elseif(isset($user))
            var newOption = new Option('{{ $user->text }}', {{ $user->id }}, true, true);
            $('.userSelect').append(newOption).trigger('change');

            var events = {
                id: 1,
                backgroundColor: '#86c651',
                borderColor: '#86c651',
                textColor: '#fff',
                url: '{{ route('events.getEvents', $user->id) }}',
            };
        @elseif(isset($event))

            var date = "{{ explode(' ', $event->start)[0] }}"
            var startTime = ConvertTimeBack("{{ explode(' ', $event->start)[1] }}")
            var endTime = ConvertTimeBack("{{ explode(' ', $event->end)[1] }}")
            $("#date").val(date);
            $("#start").val(startTime);
            $("#end").val(endTime);
            $(".submit-btn").text("{{ __('words.edit') }}")
            $(".submit-btn").removeAttr("disabled");
            var newOption = new Option('{{ $event->user->text }}', {{ $event->user->id }}, true, true);
            $('.userSelect').append(newOption).trigger('change');

            var events = {
                id: 1,
                backgroundColor: '#86c651',
                borderColor: '#86c651',
                textColor: '#fff',
                url: '{{ route('events.getEvents', $event->user->id) }}',
            };
            var PlacenewOption = new Option('{{ $event->place->text }}', {{ $event->place->id }}, true, true);
            $('.placeSelect').append(PlacenewOption).trigger('change');

            var busnewOption = new Option('{{ $event->bus->text }}', {{ $event->bus->id }}, true, true);
            $('.busSelect').append(busnewOption).trigger('change');

        @endif

        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                start: 'prev,next,today',
                center: 'title', // will normally be on the left. if RTL, will be on the right
                end: 'dayGridMonth,timeGridWeek,timeGrid', // "listDay,listWeek,listMonth,listYear,timeGrid,timeGridWeek,timeGridFourDay"
            },
            direction: 'ltr',
            eventSources: [events],
            {{--events: "{{ route('events.getEvents') }}",--}}
            // events: myData,
            viewDidMount: function (arg) {

            },
            eventContent: function(arg){
                // if(arg.view.type == "timeGridWeek" || arg.view.type == "timeGrid"){
                //     options = {
                //         year: 'numeric', month: 'numeric', day: 'numeric',
                //     };
                //     title = '<div class="date" ' +
                //         'style="font-size: 11px;direction: rtl;text-align: right;padding: 3px 6px;display: flex;justify-content: space-between;">' +
                //         '<span><span class="time-icon" style="font-size: 10px;margin-left: 3px;"><i class="far fa-clock"></i></span>' + new Intl.DateTimeFormat('en-US', options).format(arg.event.start) + '</span><span><input type="hidden" class="event_id" value="'+ arg.event.id +'"><i class="fas fa-edit edit-icon"></i></span></div>';
                //     title += '<div class="title" ' +
                //         'style="background-color: white;border: 1px solid white;color: black;font-size: 14px;font-weight: 700;text-align: right;padding: 10px 6px;border-bottom: 1px solid #c1c1c1;">' +
                //         arg.event.title + '</div>';
                //     title += '<div class="location" ' +
                //         'style="background-color: white;border: 1px solid white;color: black;font-size: 11px;direction: rtl;text-align: right;padding: 3px 6px;display: flex;justify-content: space-between;">' +
                //         '<span><span class="location-icon" style="font-size: 10px;margin-left: 3px;"><i class="fas fa-map-marker-alt"></i></span>' + arg.event.extendedProps.location + '</span><span><i class="far fa-trash-alt delete-icon"></i></span></div>';
                // }else if(arg.view.type == 'dayGridMonth'){
                //     title = '<div ' +
                //         'style="font-size: 14px;font-weight: 700;text-align: right;padding: 0px 6px;">' +
                //         arg.event.title + '</div>';
                // }
                title = '<div ' +
                    'style="font-size: 14px;font-weight: 700;text-align: right;padding: 0px 6px;">' +
                    arg.event.title + '</div>';
                arg.event.title.innerHTML = title.textContent;
                return { html: title }
            },
            eventClick: function(info) {
                openEditModal(info.event);
            },
            eventDrop: function( eventDropInfo ) {
                // console.log(convert(eventDropInfo.event.start));
                let Mydata = {
                    "_token": $('input[name="_token"]').val(),
                    "id": eventDropInfo.event.id,
                    "start": convert(eventDropInfo.event.start),
                    "end": convert(eventDropInfo.event.end),
                };
                $.ajax({
                    type: 'PUT',
                    url: '{{ route('events.updateDate') }}',
                    data: Mydata,
                    success: function (response) {
                        toastr.success(response.message);
                    },
                });
            },
            eventDidMount: function(arg){
                setTimeout(function (){
                    $(".edit-icon").each(function(){
                        $(this).on('click', function (){
                            let id = $(this).parent().find(".event_id").val();
                            let el = calendar.getEventById( id );
                            openEditModal(el);
                        })
                    });
                    $(".delete-icon").each(function(){
                        $(this).on('click', function (e){
                            e.preventDefault();
                            var btn = $(this);
                            var WillDeleteID = btn.closest('a').find('.event_id').val();
                            console.log(WillDeleteID);
                            swal({
                                title: "{{ __('words.are_you_sure') }}",
                                text: "{{ __('words.delete_sweetAlert_text') }}",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#ee335e",
                                confirmButtonText: "{{ __('words.confirm_btn_text') }}",
                                cancelButtonText: "{{ __('words.cancel_btn_text') }}",
                                closeOnConfirm: false,
                                showLoaderOnConfirm: true
                            }, function () {
                                let Mydata = {
                                    "_token": $('input[name="_token"]').val(),
                                    "id": WillDeleteID,
                                };
                                $.ajax({
                                    type: 'DELETE',
                                    url: 'events/'+ WillDeleteID,
                                    data: Mydata,
                                    success: function (response) {
                                        console.log(response);
                                        setTimeout(function () {
                                            btn.closest('a').parent().remove();
                                            swal({
                                                title: "تم الحذف",
                                                type: "success",
                                                closeOnClickOutside: true,
                                                closeOnEsc: true,
                                                timer: 1500,
                                                customClass:"deleted-alert",
                                                showConfirmButton: false,
                                                showCancelButton: false,
                                            });
                                        }, 1000);
                                    },
                                });
                            });
                        })
                    });
                    initDrag();
                    initDrop();
                }, 150);
            },
            eventDisplay: 'block',
            eventTimeFormat: { // like '14:30:00'
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                meridiem: true
            },
            editable: true,
            eventDurationEditable: false,
            eventResizableFromStart: false,
            eventDragMinDistance: 2,
            dragRevertDuration: 500,
            droppable: true,
            // displayEventTime: true,
            eventMouseEnter: function(mouseEnterInfo) {
                // show popover
            },
            eventMouseLeave: function(mouseLeaveInfo) {
                // hide popover
            },
            eventMaxStack: 2,
            eventMinHeight: 20, // for timeGrid
            eventShortHeight: 20, // for timeGrid
            slotDuration: '00:30:00', // for timeGrid
            slotLabelInterval: "01:00", // for timeGrid
            nowIndicator: true, // for timeGrid
            nowIndicatorClassNames: 'now_indicator',
            slotLabelFormat: { // for timeGrid
                hour: 'numeric',
                minute: '2-digit',
                omitZeroMinute: true, // 12:00 => 12
                meridiem: 'short'
            },
            // defaultAllDay: true,
            // defaultAllDayEventDuration: { days: 1},
            // defaultTimedEventDuration: "24:00",
            // forceEventDuration: true,
            // code: 'ar-sa',
            firstDay: 1, // monday
            slotMinTime: "00:00:00", // the first slot in the timeGrid
            slotMaxTime: "23:59:59", // the end slot in the timeGrid
            scrollTime: "00:00:00", // initial time, the scroll bar will scroll to it at the first
            slotEventOverlap: true, // for timeGrid
            allDaySlot: false,
            dayHeaderFormat: { weekday: 'long' },
            dayHeaderClassNames: 'headers',
            dayCellClassNames: "cell",
            slotLabelClassNames: 'labels', // for timegrid
            slotLaneClassNames: 'beside-labels',
            stickyHeaderDates: true,
            handleWindowResize: true,
            // height: 1000,
            dayMaxEvents: true,
            themeSystem: 'bootstrap',
            navLinks: true,
            weekNumbers: false,
            selectable: true,
            selectMirror: false, // for timeGrid
            unselectAuto: true,
            selectOverlap: true,
            selectMinDistance: 5,
            select: function(info) {
                startDateTime(info.start)
                endDateTime(info.end)
                $(`#${modalId}`).modal('show');
            },
            bootstrapFontAwesome: { // when cahnge th bootstrap theme
                close: 'fa-times',
                prev: 'fa-chevron-left',
                next: 'fa-chevron-right',
                prevYear: 'fa-angle-double-left',
                nextYear: 'fa-angle-double-right'
            },
            expandRows: true,
            views: {
                dayGridMonth: {
                    titleFormat: { year: 'numeric', month: 'long'}
                },
                dayGridWeek: {
                    titleFormat: { year: 'numeric', month: '2-digit', day: '2-digit' }
                }
            },
            fixedWeekCount: false, // if true, the month view will always have 6 columns
            showNonCurrentDates: false, // this will disapperar the dates of the previous month dates
            initialView: "dayGridMonth",
            dragScroll: true,
            // eventClassNames: function (arg) {
            //     if (arg.event.extendedProps.isUrgent) {
            //         return ['urgent']
            //     } else {
            //         return ['normal']
            //     }
            // },
        });
        calendar.render();
        function openEditModal(el){
            console.log(el.id);
            let route = "{{ route('events.index') }}" + "/" + el.id + "/getData";
            let token = "{{ csrf_token()}}";
            $.ajax({
                url: route,
                type: 'POST',
                data: {
                    _token:token,
                },
                success: function(response) {
                    $(".modal #title").val(response.title);
                    $(".modal .placeDiv .select2 .select2-selection__placeholder").text(response.place.name);
                    $(".modal .busDiv .select2 .select2-selection__placeholder").text(response.busNo);
                    $(".modal #start_km").val(response.start_km);
                    $(".modal #end_km").val(response.end_km);
                    $(".modal #date").val((response.start).split(' ')[0]);
                    $(".modal #start").val(ConvertTimeBack((response.start).split(' ')[1]));
                    $(".modal #end").val(ConvertTimeBack((response.end).split(' ')[1]));
                    $(".modal #stopsNum").val(response.stopsNum);
                    $(".modal .modal-edit-btn").attr('href', '{{ url('/events') }}' + "/" + response.id + "/edit");
                    $(".modal #modal-delete-btn").attr('action', '{{ url('/events') }}' + "/" + response.id);
                    $(`#${modalId}`).modal('show');
                },
                error: function(xhr) {
                    toastr.error("Something Went Wrong! Try Again Later.", "Error");
                }
            });
        }
        $('#modal-delete-btn button').on('click', function (e){
            e.preventDefault();
            let icon = this;
            $(`#${modalId}`).modal('hide');
            setTimeout(function(){
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
                            $("#modal-delete-btn").submit()
                        },500)
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        if(hasOpenedModal){
                            $(`#${modalId}`).modal('show');
                        }
                    }
                })
            }, 100)
        })
        function convert(date){
            let d = new Date(date);
            let month = "" + (d.getMonth() + 1);
            let day = "" + d.getDate();
            let year = "" + d.getFullYear();
            if(month.length < 2) month = "0" + month;
            if(day.length < 2) day = "0" + day;
            let time = d.toTimeString({ hour: '2-digit', minute: '2-digit', second: '2-digit' }).split(' ')[0];
            return [year,month,day].join('-') + ' ' + time;
        }

        function ConvertTimeBack(time){ // 18:04:00
            let hour = time.split(':')[0] // 18
            let min = time.split(':')[1]; // 04

            if(parseInt(hour) > 12){
                hour = parseInt(hour) - 12;
                suffix = 'PM';
            }else{
                suffix = 'AM'
            }
            let final_time = hour + ':' + min + ' ' + suffix;
            return final_time;
        }
        function initDrag(){
            $(".dayGrid-event").draggable({
                helper: "clone",
                delay: 0,
                revert: "invalid",
                scroll: false
            });
        }
        function initDrop(){
            $(".dayGrid-day").droppable({
                drop: function (event, ui) {
                    let myElement = ui.draggable;
                    setTimeout(function () {
                        initDrag();
                        ui.helper.addClass(dayClass);
                    }, 100);
                }
            });
        }
        function startDateTime(start){
            date = new Date(start);
            year = date.getFullYear();
            month = date.getMonth()+1;
            dt = date.getDate();
            if (dt < 10) {
                dt = '0' + dt;
            }
            if (month < 10) {
                month = '0' + month;
            }
            dateFormat = year + '-' + month + '-' + dt;
            $('#event_start').datepicker('setDate', dateFormat);
            time = new Date(start);
            t = time.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true});
            $('#start').timepicker('setTime', t);
        }
        function endDateTime(end){
            date = new Date(end);
            year = date.getFullYear();
            month = date.getMonth()+1;
            dt = date.getDate();
            if (dt < 10) {
                dt = '0' + dt;
            }
            if (month < 10) {
                month = '0' + month;
            }
            dateFormat = year + '-' + month + '-' + dt;
            $('#event_end').datepicker('setDate', dateFormat);
            time = new Date(end);
            t = time.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true});
            $('#end').timepicker('setTime', t);
        }
        initDrag();
        initDrop();
    </script>
    <script>
        $(document).ready(function (){
            $('.delete-icon').each(function(){
                $(this).on('click', function (e) {

                });
            });
        });

        function convertDate(){
            $('#event_start').val($('#event_start').val() + ' ' + changeTimeFormat($('#start').val()));
            if($('#event_end').val())
                $('#event_end').val($('#event_end').val() + ' ' + changeTimeFormat($('#end').val()));
        }

        function changeTimeFormat(time){ // 8:12 AM
            let hour = time.split(' ')[0].split(':')[0]; // 8
            let min = time.split(' ')[0].split(':')[1]; // 12
            let sec = '00';
            if(hour.length == 1)
                hour = '0' + hour
            if(time.split(' ')[1] == 'PM'){
                hour = parseInt(hour) + 12;
            }
            let final_time = hour + ':' + min + ':' + sec;
            if(final_time == '24:00:00'){
                final_time = '23:59:59';
            }
            return final_time;
        }
    </script>
    <script>
        $('.userSelect').select2({
            placeholder: "{{ __('words.choose_username') }}",
            language: "ar",
            searchInputPlaceholder: 'Enter username..',
            width: '100%',
            ajax: {
                url: '{{ route('users.findUser') }}',
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
        $('.placeSelect').select2({
            placeholder: "{{ __('words.choose_place') }}",
            searchInputPlaceholder: 'Enter Place Name..',
            @error('place_id')
            dropdownCssClass : 'error',
            selectionCssClass: 'error',
            @enderror
            width: '100%',
            ajax: {
                url: '{{ route('places.findPlace') }}',
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
        $('.busSelect').select2({
            placeholder: "{{ __('words.choose_busNo') }}",
            searchInputPlaceholder: 'Enter Bus Number..',
            width: '100%',
            @error('busNo')
            dropdownCssClass : 'error',
            selectionCssClass: 'error',
            @enderror
            ajax: {
                url: '{{ route('users.findBus') }}',
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

        $('input.datepicker').datepicker({
            format: "yyyy-mm-dd",
            maxViewMode: 2,
            weekStart: 1,
            orientation: "bottom auto",
            autoclose: true,
            todayHighlight: true
        }).on('change', function(event) {});
        $('.time-input').timepicker({
            minuteStep: 1,
            defaultTime: false,
            icons: {
                up: 'fa fa-angle-up',
                down: 'fa fa-angle-down'
            },
        });
    </script>
@endpush
