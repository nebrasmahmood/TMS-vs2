@extends("layout.master")
@section("css-scripts")
    <link href="{{ asset('assets/css/select2.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <style>
        span {
            display: block;
        }
        .text-muted{
            margin-left: 6px;
            font-size: 80%;
        }
        td.bg-danger{
            color: #721c24 !important;
            background-color: #f8d7da !important;
            border-color: #f5c6cb !important;
        }
        .coution{
            display: none;
            margin-right: 0.5rem;
            color: red;
        }
        .table-head {
            background-color: #02a4e1!important;
            color: white;
            position: sticky;
            top: 0;
            z-index: 1;
        }
        .table {
            overflow: auto;
        }
        table th.header {
            position: sticky;
            top:0;
        }
        table td{
            position: relative;
        }
        table td > span.busNumber{
            position: absolute;
            bottom: 12px;
        }
        .bg-secondary{
            background-color: #cddae6 !important;
        }

        .table-responsive::-webkit-scrollbar {
            width: 16px;
        }
        .table-responsive::-webkit-scrollbar-track {
            background: #86c65161;
        }
        .table-responsive::-webkit-scrollbar-thumb {
            background-color: #86c651;
            border-radius: 20px;
            border: 3px solid #86c65161;
        }
        tbody th {
            cursor: pointer;
        }
        /*.text-danger{*/
        /*    color: #721c24 !important;*/
        /*}*/
    </style>
@endsection
@section('content')
    <div class="container-fluid pr-0">
        <div class="row mr-0">
            <div class="col-12 pr-0">
                <div class="table-responsive pr-3">
                    <form class="row m-0">
                        <div class="col-11 p-0 m-0">
                            <div class="row p-0 m-0">
                                <div class="col-4 pl-0">
                                    <div class="form-group">
                                        <label for="startDate" class="form-control-label">Start Date<span class="d-inline text-muted">(YYYY-MM-DD)</span></label>
                                        <input type="text" id="startDate" name="from" value="{{ request()->query('from') ?? "" }}" placeholder="Enter start date.." class="form-control datepicker is-valid @error('startDate')is-invalid @enderror" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="endDate" class="form-control-label">End Date<span class="d-inline text-muted">(YYYY-MM-DD)</span></label>
                                        <input type="text" id="endDate" name="to" value="{{ request()->query('to') ?? "" }}" placeholder="Enter end date.." class="form-control datepicker is-valid @error('endDate')is-invalid @enderror" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="NumberOfWeeks" class="form-control-label">Number of weeks</label>
                                        <input type="number" id="NumOfWeeks" min="1" max="53" name="NumOfWeeks" value="{{ request()->query('NumOfWeeks') ?? "" }}" placeholder="Enter number of weeks.." class="form-control is-valid @error('NumberOfWeeks')is-invalid @enderror">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-1 pr-0 d-flex justify-content-center align-items-end mb-3">
                            <button type="submit" class="btn btn-success w-100" style="border-radius: 0.25rem;">Search</button>
                        </div>
                    </form>
                    <table class="table table-bordered mb-0">
                        <thead class="table-head">
                        <tr>
                            <th class="header" scope="col"></th>
                            @foreach ($places as $place)
                                <th class="header" scope="col">{{ $place['number'] }}<span>{{ $place['name'] }}</span></th>
                            @endforeach
                            <th class="header bg-danger" scope="col" style="vertical-align:middle;">
                                Absencese
                            </th>
                            <th class="header bg-warning" scope="col" style="vertical-align:middle;">
                                Sickness
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($result as $weekNo => $dates)
                            <tr class="bg-secondary colspan">
                                <td colspan="{{ count($places) + 3 }}">Week {{ $weekNo }}</td>
                            </tr>
                            @foreach ($dates as $date => $placesId)
                                <tr id="{{ $days[$loop->index]. '-' .$weekNo }}" date="{{ $date }}">
                                    <th scope="row"><span class="coution"><i class="fas fa-exclamation-triangle"></i></span>{{ $days[$loop->index] }}<span>{{ $date }}</span></th>
                                    @foreach($placesId as $placeId => $jobData)
                                        @if($placeId == 'absencese')
                                            <td class="absencese">
                                                @foreach($jobData[0] as $absentUser)
                                                    <span userId="{{ $absentUser->user->id ?? '' }}">{{ $absentUser->user->fname ?? 0 }}</span>
                                                @endforeach
                                            </td>
                                        @elseif($placeId == 'sickness')
                                            <td class="sickness">
                                                @foreach($jobData[0] as $sickUser)
                                                    <span userId="{{ $sickUser->user->id ?? '' }}">{{ $sickUser->user->fname ?? 0 }}</span>
                                                @endforeach
                                            </td>
                                        @else($placeId != 'absencese' && $placeId != 'sickness')
                                        <td class="place_cell" placeId="{{ $placeId }}" jobId="{{ $jobData[0]->id ?? '' }}" userId="{{ $jobData[0]->user->id ?? '' }}" busNo="{{ $jobData[0]->busNo ?? '' }}">{{ $jobData[0]->user->fname ?? '' }}<span class="busNumber">{{ $jobData[0]->busNo ?? '' }}</span></td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade p-0" id="AddJobModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title" id="modalTitle"></h5>
                        <span id="date"></span>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group row">
                            <label for="user_id" class="col-sm-3 col-form-label">Username</label>
                            <div class="col-sm-9">
                                <select class="form-control userSelect" id="user_id" name="user_id">
                                    <option value="0" selected>{{ __('words.choose_username') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="bus_no" class="col-sm-3 col-form-label">Bus Number</label>
                            <div class="col-sm-9">
                                <select class="form-control busSelect" id="bus_no" name="busNo">
                                    <option value="0" selected>{{ __('words.choose_busNo') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="stops_no" class="col-sm-3 col-form-label">Stops Number</label>
                            <div class="col-sm-9">
                                <input type="number" id="stops_no" name="stops_no" value="{{ old('stops_no') }}" placeholder="Enter stops number.." class="form-control is-valid @error('stops_no')is-invalid @enderror">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="anotherStops_no" class="col-sm-3 col-form-label">Another Stops Number</label>
                            <div class="col-sm-9">
                                <input type="number" id="anotherStops_no" name="anotherStops_no" value="{{ old('anotherStops_no') }}" placeholder="Enter another stops number.." class="form-control is-valid @error('anotherStops_no')is-invalid @enderror">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cube_no" class="col-sm-3 col-form-label">Cube Number</label>
                            <div class="col-sm-9">
                                <input type="number" id="cube_no" name="cube_no" value="{{ old('cube_no') }}" placeholder="Enter cube number.." class="form-control is-valid @error('cube_no')is-invalid @enderror">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="percentage" class="col-sm-3 col-form-label">Percentage</label>
                            <div class="col-sm-9">
                                <input type="number" id="percentage" name="percentage" value="{{ old('percentage') }}" placeholder="Enter percentage.." class="form-control is-valid @error('percentage')is-invalid @enderror">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="notes" class="col-sm-3 col-form-label">Notes</label>
                            <div class="col-sm-9">
                                <textarea id="notes" name="notes" placeholder="Enter notes.." class="form-control is-valid @error('notes')is-invalid @enderror"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="helper_id" class="col-sm-3 col-form-label">Username</label>
                            <div class="col-sm-9">
                                <select class="form-control helperSelect" id="helper_id" name="helper_id">
                                    <option value="0" selected>{{ __('words.choose_helperName') }}</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ asset('/assets/js/select2.min.js')}}"></script>
    <script>
        $('input.datepicker').datepicker({
            format: "yyyy-mm-dd",
            maxViewMode: 2,
            weekStart: 1,
            orientation: "bottom auto",
            autoclose: true,
            todayHighlight: true
        }).on('change', function(event) {

        });
    </script>
    <script>
        $(window).resize(function(event){
            $(".table-responsive").css("height", $(window).height() - $(".table-responsive").offset().top )
        })
        $(".table-responsive").css("height", $(window).height() - $(".table-responsive").offset().top + 20)
        innerArray = {}
        var valueGroups = $(".table tbody tr:not(.colspan)").filter(function(index){
            users=[]
            buses=[]
            duplicatedBuses = []
            duplicatedUsers = []
            rowId = $(this).attr('id');
            for (let i = 0; i < {{ count($places) + 2 }}; i++){
                td = $(this).find('td')[i];
                if(td.className == 'absencese' || td.className == 'sickness'){
                    el = $(td)[0]
                    userId = $(el).find('span').attr('userId');
                    if(userId && users.includes(userId)){
                        duplicatedUsers.push(userId);
                        tr = $(`.table tbody tr#${rowId}`)
                        tr.find("td[userId=" + userId + "]").addClass('bg-danger')
                        tr.find("td span[userId=" + userId + "]").parent().addClass('bg-danger')
                        coutionSpan = tr.find(".coution")
                        coutionSpan.css("display", 'inline')
                    }
                    else
                        if(userId)
                            users.push(userId)

                    continue;
                }
                userId = td.getAttribute("userId");
                busNumber = td.getAttribute("busNo");
                if(userId && users.includes(userId)){
                    duplicatedUsers.push(userId);
                    tr = $(`.table tbody tr#${rowId}`)
                    tr.find("td[userId=" + userId + "]").addClass('bg-danger')
                    coutionSpan = tr.find(".coution")
                    coutionSpan.css("display", 'inline')
                }
                else
                    if(userId)
                        users.push(userId)

                if(busNumber && buses.includes(busNumber)){
                    tr = $(`.table tbody tr#${rowId}`)
                    tr.find("td[busNo=" + busNumber + "]").addClass('bg-danger')
                    duplicatedBuses.push(busNumber);
                    coutionSpan = $(`.table tbody tr#${rowId}`).find(".coution")
                    coutionSpan.css("display", 'inline')
                }
                else
                    if(busNumber)
                        buses.push(busNumber)
            }
            innerArray[rowId] = {};
            innerArray[rowId]['users'] = users
            innerArray[rowId]['buses'] = buses
            innerArray[rowId]['duplicatedBuses'] = duplicatedBuses
            innerArray[rowId]['duplicatedUsers'] = duplicatedUsers
            return $(this);
        }).get();

        $(".table tbody tr td.place_cell").on('click', function(){
            console.log("clicked");
            var jobId = $(this).attr('jobId')
            if(jobId){
                // get data by ajax
            }else{
                $("#AddJobModal").modal('show');
                $("body").css('padding', '0px !important')
                day = $(this).parent().attr('id').split('-')[0];
                date = $(this).parent().attr('date');
                $("#modalTitle").text(day);
                $("#date").text(date);
                console.log(day)
            }
            console.log()
        })

        $('.userSelect').select2({
            placeholder: "{{ __('words.choose_username') }}",
            language: "ar",
            searchInputPlaceholder: 'Enter username..',
            width: '100%',
            templateResult: formatUser,
            templateSelection: SelectUser,
            dropdownParent: $("#AddJobModal"),
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

        function formatUser (opt) {
            if(opt.busNo){
                var $opt = $(
                    '<span>' + opt.text + '<span class="inner-span" style="font-size: 80%; color: #868e96;">Bus No: ' + opt.busNo + '</span></span>'
                );
            }else{
                var $opt = $(
                    '<span>' + opt.text + '</span>'
                );
            }
            return $opt;
        }
        function SelectUser (opt) {
            if(opt.busNo){
                var newOption = new Option(`${opt.busNo}`, opt.id, true, true);
                $('.busSelect').append(newOption).trigger('change');
            }
            var $opt = $(
                '<span>' + opt.text + '</span>'
            );
            return $opt;
        }

        $('.busSelect').select2({
            placeholder: "{{ __('words.choose_busNo') }}",
            searchInputPlaceholder: 'Enter Bus Number..',
            width: '100%',
            templateResult: formatBus,
            templateSelection: SelectBus,
            dropdownParent: $("#AddJobModal"),
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

        function formatBus (opt) {
            if (opt.user) {
                var $opt = $(
                    '<span>' + opt.text + '<span class="inner-span" style="font-size: 80%; color: #868e96;">User: ' + opt.user + '</span></span>'
                );
            } else {
                var $opt = $(
                    '<span>' + opt.text + '</span>'
                );
            }
            return $opt;
        }

        function SelectBus (opt) {
            if(opt.user){
                var newOption = new Option(`${opt.user}`, opt.id, true, true);
                $('.userSelect').append(newOption).trigger('change');
            }
            var $opt = $(
                '<span>' + opt.text + '</span>'
            );
            return $opt;
        }

        $(".select2").on('click', function(){
            console.log($(this));
            $(this).find("input.select2-search__field").focus();
        });

        $("tbody th").on('click', function(){

            window.location.href = ""
            console.log($(this).parent().attr("id"));
        });


        $('.helperSelect').select2({
            placeholder: "{{ __('words.choose_username') }}",
            language: "ar",
            searchInputPlaceholder: 'Enter username..',
            width: '100%',
            templateResult: formatUser,
            dropdownParent: $("#AddJobModal"),
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
    </script>
@endpush
