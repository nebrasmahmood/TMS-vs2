@extends('layout.master')
@section('css-scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link href="{{ asset('assets/css/index-pages.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/fullcalendar-main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fullcalendar.css') }}">
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
                    <h1>{{ __('nl-words.Jobs') }}</h1>
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
                            <a href="{{ route('events.index') }}">{{ __('nl-words.Week Jobs') }}</a>
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
                    <div class="row">
                        <div class="col-lg-12 col-md-12 pl-0">
                            <div class="main-content-body main-content-body-calendar card p-4">
                                <div class="main-calendar" id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->
    </div>
    <!-- /row -->
@endsection
@push('scripts')
    <script>
        window.days = ["{{ __('nl-words.saturday') }}", "{{ __('nl-words.sunday') }}", "{{ __('nl-words.monday') }}", "{{ __('nl-words.tuesday') }}", "{{ __('nl-words.wednesday') }}", "{{ __('nl-words.thersday') }}", "{{ __('nl-words.friday') }}"];
    </script>
    <script src="{{ asset('assets/js/fullcalendar-main.min.js') }}"></script>
    <script>
        var events = {
            id: 1,
            backgroundColor: '#86c651',
            borderColor: '#86c651',
            textColor: '#fff',
            url: '{{ route('jobs.getWeekJobs', date_format(date_create(), 'W')) }}',
        };
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                start: 'prev,next',
                center: 'title', // will normally be on the left. if RTL, will be on the right
                end: 'today', // "listDay,listWeek,listMonth,listYear,timeGrid,timeGridWeek,timeGridFourDay"
            },
            direction: 'ltr',
            eventSources: [events],
            {{--events: "{{ route('events.getEvents') }}",--}}
            // events: myData,
            eventContent: function(arg){
                console.log(arg)
                title = '<div ' +
                    'style="font-size: 14px;font-weight: 700;text-align: left;padding: 10px 6px;">' +
                        '<span>Place: '+
                        arg.event.extendedProps.place.name +
                    '</span></div>';
                arg.event.title.innerHTML = title.textContent;
                return { html: title }
            },
            eventDisplay: 'block',
            eventTimeFormat: { // like '14:30:00'
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                meridiem: true
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
            height: 400,
            dayMaxEvents: true,
            themeSystem: 'bootstrap',
            navLinks: true,
            weekNumbers: false,
            selectable: true,
            selectMirror: false, // for timeGrid
            unselectAuto: true,
            selectOverlap: true,
            selectMinDistance: 5,
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
            initialView: "dayGridWeek",
        });
        calendar.render();
    </script>
@endpush
