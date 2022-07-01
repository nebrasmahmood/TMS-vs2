@extends("layout.master")
@section("css-scripts")
    <meta name="csrf-token" content="{{ csrf_token() }}" />
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
            min-width: 60px;
        }
        table td > span.busNumber{
            position: absolute;
            bottom: 12px;
        }
        .bg-secondary{
            background-color: #cddae6 !important;
        }

        .table-responsive::-webkit-scrollbar {
            width: 14px;
        }
        .table-responsive::-webkit-scrollbar-track {
            background: #86c65161;
        }
        .table-responsive::-webkit-scrollbar-thumb {
            background-color: #86c651;
            border-radius: 20px;
            border: 3px solid #86c65161;
        }
        tbody th, tbody td:not([colspan]) {
            cursor: pointer;
        }
        .invalid-feedback {
            display: block;
        }
        body.open .table-responsive{
            width: calc(100vw - 88px);
            transition: all 1s cubic-bezier(0,1.4,1,.45);
        }
        body:not(.open) .table-responsive{
            width: calc(100vw - 298px);
            transition: all 1s cubic-bezier(0,1.4,1,.45);
        }
        body:not(.open) aside{
            width: 280px !important;
            transition: all 1s cubic-bezier(0,1.4,1,.45);
        }

        @media only screen and (max-width: 991.5px){
            .pl-0-md{
                padding-left: 0px !important;
            }
            .pr-0-md{
                padding-right: 0px !important;
            }
        }
        @media only screen and (max-width: 767.5px){
            .pl-15-sm{
                padding-left: 15px !important;
            }
            .pr-15-sm{
                padding-right: 15px !important;
            }
        }
        .table tbody th, .table .thead th:first-child {
            text-align: inherit;
            position: sticky;
            left: 0;
            z-index: 1;
            background: white;
        }
        .table thead th:first-child {
            z-index: 3;
            left: 0;
            background: #02a4e1;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid pr-0">
        <div class="row mr-0">
            @foreach($errors->all() as $error)
                <span>{{ $error }}</span>
            @endforeach
            <div class="col-12 pr-0">
                <form class="row m-0">
                    <div class="col-lg-4 col-md-6 pl-0 pl-15-sm">
                        <div class="form-group">
                            <label for="startDate" class="form-control-label">Start Date<span class="d-inline text-muted">(YYYY-MM-DD)</span></label>
                            <input type="text" id="startDate" name="from" value="{{ request()->query('from') ?? "" }}" placeholder="Enter start date.." class="form-control datepicker is-valid @error('startDate')is-invalid @enderror" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 pr-15-sm">
                        <div class="form-group">
                            <label for="endDate" class="form-control-label">End Date<span class="d-inline text-muted">(YYYY-MM-DD)</span></label>
                            <input type="text" id="endDate" name="to" value="{{ request()->query('to') ?? "" }}" placeholder="Enter end date.." class="form-control datepicker is-valid @error('endDate')is-invalid @enderror" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 pl-0-md pl-15-sm">
                        <div class="form-group">
                            <label for="NumOfWeeks" class="form-control-label">Number of weeks</label>
                            <input type="number" id="NumOfWeeks" min="1" max="53" name="NumOfWeeks" value="{{ request()->query('NumOfWeeks') ?? "" }}" placeholder="Enter number of weeks.." class="form-control is-valid @error('NumberOfWeeks')is-invalid @enderror">
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-6 pr-15-sm d-flex justify-content-center align-items-end mb-3">
                        <button type="submit" id="search-btn" class="btn btn-success w-100" style="border-radius: 0.25rem;">Search</button>
                    </div>
                </form>
                <div class="table-responsive pr-3">
                    <table class="table table-bordered mb-0">
                        <thead class="table-head">
                        <tr>
                            <th class="header" scope="col"></th>
                            @foreach ($places as $place)
                                <th class="header" scope="col">{{ $place['number'] }}<span>{{ $place['name'] }}</span></th>
                            @endforeach
                            <th colspan="4" class="header bg-danger" scope="col" style="vertical-align:middle;">
                                Absencese
                            </th>
                            <th colspan="2" class="header bg-warning" scope="col" style="vertical-align:middle;">
                                Sickness
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($result as $weekNo => $dates)
                            <tr class="bg-secondary colspan">
                                <td colspan="{{ count($places) + 7 }}">Week {{ $weekNo }}</td>
                            </tr>
                            @foreach ($dates as $date => $placesId)
                                <tr id="{{ $days[$loop->index]. '-' .$weekNo }}" date="{{ $date }}">
                                    <th scope="row"><span class="coution"><i class="fas fa-exclamation-triangle"></i></span>{{ $days[$loop->index] }}<span>{{ $date }}</span></th>
                                    @foreach($placesId as $placeId => $jobData)
                                        @if($placeId == 'absencese')
                                            @for($i = 0; $i < 4; $i++)
                                                @if(isset($jobData[0][$i]))
                                                    <td class="absencese reason" absenceseId="{{ $jobData[0][$i]->id ?? '' }}" userId="{{ $jobData[0][$i]->user->id ?? '' }}">
                                                        <span>{{ $jobData[0][$i]->user->fname ?? 0 }}</span>
                                                    </td>
                                                @else
                                                <td class="absencese reason" absenceseId="" userId=""></td>
                                                @endif
                                            @endfor
                                        @elseif($placeId == 'sickness')
                                            @for($i = 0; $i < 2; $i++)
                                                @if(isset($jobData[0][$i]))
                                                    <td class="sickness reason" absenceseId="{{ $jobData[0][$i]->id ?? '' }}" userId="{{ $jobData[0][$i]->user->id ?? '' }}">
                                                        <span>{{ $jobData[0][$i]->user->fname ?? 0 }}</span>
                                                    </td>
                                                @else
                                                    <td class="sickness reason" absenceseId="" userId=""></td>
                                                @endif
                                            @endfor
                                        @else($placeId != 'absencese' && $placeId != 'sickness')
                                        <td class="place_cell" placeId="{{ $placeId }}" jobId="{{ $jobData[0]->id ?? '' }}" userId="{{ $jobData[0]->user->id ?? '' }}" busNo="{{ $jobData[0]->busNo ?? ($jobData[0]->user->busNo ?? '') }}">{{ $jobData[0]->user->fname ?? '' }}<span class="busNumber">{{ $jobData[0]->busNo ?? ($jobData[0]->user->busNo ?? '') }}</span></td>
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
                    <form id="addJobForm" action="{{ route('jobs.store') }}" method="post">
                        @csrf()
                        <input type="hidden" id="_method" name="_method" value="">
                        <input type="hidden" name="place_id" id="PlaceIdInput" />
                        <input type="hidden" name="date" id="dateInput" />
                        <div class="form-group row">
                            <label for="user_id" class="col-sm-3 col-form-label">Username</label>
                            <div class="col-sm-9">
                                <select class="form-control @error('user_id') is-invalid @enderror userSelect" id="user_id" name="user_id">
                                    <option value="0" selected>{{ __('words.choose_username') }}</option>
                                </select>
                                @error("user_id")
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="bus_no" class="col-sm-3 col-form-label">Bus Number</label>
                            <div class="col-sm-9">
                                <select class="form-control busSelect" id="bus_no" name="busNo" disabled>
                                    <option value="0" selected>{{ __('words.choose_busNo') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="stops_no" class="col-sm-3 col-form-label">Stops Number</label>
                            <div class="col-sm-9">
                                <input type="number" id="stops_no" name="stops_no" value="{{ old('stops_no') }}" placeholder="Enter stops number.." class="form-control is-valid @error('stops_no')is-invalid @enderror">
                                @error('stops_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="AnotherstopsNo" class="col-sm-3 col-form-label">Another Stops Number</label>
                            <div class="col-sm-9">
                                <input type="number" id="AnotherstopsNo" name="AnotherstopsNo" value="{{ old('AnotherstopsNo') }}" placeholder="Enter another stops number.." class="form-control is-valid @error('AnotherstopsNo')is-invalid @enderror">
                                @error('AnotherstopsNo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cube_no" class="col-sm-3 col-form-label">Cube Number</label>
                            <div class="col-sm-9">
                                <input type="number" id="cube_no" name="cube_no" value="{{ old('cube_no') }}" placeholder="Enter cube number.." class="form-control is-valid @error('cube_no')is-invalid @enderror">
                                @error('cube_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="percentage" class="col-sm-3 col-form-label">Percentage</label>
                            <div class="col-sm-9">
                                <input type="number" id="percentage" name="percentage" value="{{ old('percentage') }}" placeholder="Enter percentage.." class="form-control is-valid @error('percentage')is-invalid @enderror">
                                @error('percentage')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="notes" class="col-sm-3 col-form-label">Notes</label>
                            <div class="col-sm-9">
                                <textarea id="notes" name="notes" placeholder="Enter notes.." class="form-control is-valid @error('notes')is-invalid @enderror"></textarea>
                                @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="helper_id" class="col-sm-3 col-form-label">Helper</label>
                            <div class="col-sm-9">
                                <select class="form-control @error('helper_id') is-invalid @enderror helperSelect" id="helper_id" name="helper_id">
                                    <option value="0" selected>{{ __('words.choose_helperName') }}</option>
                                </select>
                                @error('helper_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" onclick="$('#addJobForm').submit()" class="btn btn-success">Save</button>
                    <form method="POST" id="deleteJobForm" style="display: none;">
                        @csrf()
                        @method('delete')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade p-0" id="absenceseModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title" id="absentModalTitle"></h5>
                        <span id="absentDate"></span>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addAbsentForm" action="{{ route('jobs.storeAbsencese') }}" method="post">
                        @csrf()
                        <input type="hidden" id="absent_method" name="_method" value="">
                        <input type="hidden" name="adsent_date" id="absent_date" />
                        <input type="hidden" name="reason" id="reason" />
                        <div class="form-group row">
                            <label for="absent_user_id" class="col-sm-3 col-form-label">Username</label>
                            <div class="col-sm-9">
                                <select class="form-control @error('absent_user_id') is-invalid @enderror absentUser" id="absent_user_id" name="absent_user_id">
                                    <option value="0" selected>{{ __('words.choose_username') }}</option>
                                </select>
                                @error("absent_user_id")
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" onclick="$('#addAbsentForm').submit()" class="btn btn-success" disabled>Save</button>
                    <form method="POST" id="deleteAbsentForm" style="display: none;">
                        @csrf()
                        @method('delete')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ asset('/assets/js/select2.min.js')}}"></script>
    <script>
        $("#search-btn").on('click', function (e){
            e.preventDefault();
            if(!$("#NumOfWeeks").val()){
                $("#NumOfWeeks").val('1');
            }
            $(this).closest('form').submit();
        })
        $('input.datepicker').datepicker({
            format: "yyyy-mm-dd",
            maxViewMode: 2,
            weekStart: 1,
            orientation: "bottom auto",
            autoclose: true,
            todayHighlight: true
        }).on('change', function(event) {

        });
        @if(isset($errors) && count($errors) > 0)
            $('#AddJobModal').modal('show');
        @endif
    </script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        $(window).resize(function(event){
            $(".table-responsive").css("height", $(window).height() - $(".table-responsive").offset().top )
        })
        $(".table-responsive").css("height", $(window).height() - $(".table-responsive").offset().top)
        // $(".table-responsive").css("width",  'calc(100vw - 85px)');
        innerArray = {}
        var valueGroups = $(".table tbody tr:not(.colspan)").filter(function(index){
            users=[]
            buses=[]
            duplicatedBuses = []
            duplicatedUsers = []
            rowId = $(this).attr('id');
            for (let i = 0; i < {{ count($places) + 6 }}; i++){
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
            var placeId = $(this).attr('placeid');
            var jobId = $(this).attr('jobId')
            var date = $(this).parent().attr('date');
            $("body").css('padding', '0px !important')
            day = $(this).parent().attr('id').split('-')[0];
            date = $(this).parent().attr('date');
            $("#modalTitle").text(day);
            $("#date").text(date);
            if(jobId){
                $('#PlaceIdInput').val(placeId);
                $('#dateInput').val(date)
                let route = "{{ route('jobs.getData') }}";
                let token = "{{ csrf_token()}}";
                $.ajax({
                    url: route,
                    type: 'POST',
                    data: {
                        _token:token,
                        job_id:jobId,
                    },
                    success: function(response) {
                        var newOption = new Option(`${response.user.text}`, response.user.id, true, true);
                        $('.userSelect').append(newOption).trigger('change');
                        var newBusOption = new Option(`${response.user.busNo}`, response.user.id, true, true);
                        $('.busSelect').append(newBusOption).trigger('change');
                        $("#stops_no").val(response.stops_no)
                        $("#AnotherstopsNo").val(response.AnotherstopsNo)
                        $("#cube_no").val(response.cube_no)
                        $("#percentage").val(response.percentage)
                        $("#notes").text(response.notes)
                        if(response.helper_id){
                            var newHelperOption = new Option(`${response.helper.text}`, response.helper.id, true, true);
                            $('.helperSelect').append(newHelperOption).trigger('change');
                        }else{
                            var newHelperOption = new Option("{{ __('words.choose_helperName') }}", 0, true, true);
                            $('.helperSelect').append(newHelperOption).trigger('change');
                        }
                        $("#addJobForm").attr('action', '{{ url('/') }}/jobs/update/' + response.id);
                        $('#_method').val('put')
                        $(".invalid-feedback").remove()
                        $("#addJobForm .is-invalid").removeClass('is-invalid');
                        $("#AddJobModal .modal-footer > button").text('Edit');
                        $("#AddJobModal #deleteJobForm").css('display', 'block');
                        $("#AddJobModal #deleteJobForm").attr('action', '{{ url('/') }}/jobs/'+ response.id);
                        $("#AddJobModal").modal('show');
                    },
                    error: function(xhr) {
                        //Do Something to handle error
                    }
                });
            }else{
                $('#PlaceIdInput').val(placeId);
                $('#dateInput').val(date)

                var newOption = new Option("{{ __('words.choose_username') }}", 0, true, true);
                $('.userSelect').append(newOption).trigger('change');
                var newBusOption = new Option("{{ __('words.choose_busNo') }}", 0, true, true);
                $('.busSelect').append(newBusOption).trigger('change');
                $("#stops_no").val('')
                $("#AnotherstopsNo").val('')
                $("#cube_no").val('')
                $("#percentage").val('')
                $("#notes").text('')
                var newHelperOption = new Option("{{ __('words.choose_helperName') }}", 0, true, true);
                $('.helperSelect').append(newHelperOption).trigger('change');
                $("#addJobForm").attr('action', '{{ route('jobs.store') }}');
                $('#_method').val('')
                $(".invalid-feedback").remove()
                $("#addJobForm .is-invalid").removeClass('is-invalid');
                $("#AddJobModal .modal-footer > button").text('Save');
                $("#AddJobModal #deleteJobForm").css('display', 'none');
                $("#AddJobModal #deleteJobForm").attr('action', '');
                $("#AddJobModal").modal('show');
            }
        })

        $(".table tbody tr td.reason").on('click', function(){
            let absenceseId = $(this).attr('absenceseId');
            var date = $(this).parent().attr('date');
            var reason = $(this).hasClass('absencese') ? 0 : 1;
            $('#absent_date').val(date)
            $('#reason').val(reason);
            $("body").css('padding', '0px !important')
            let day = $(this).parent().attr('id').split('-')[0];
            $("#absentModalTitle").text(day);
            $("#absentDate").text(date);
            if(absenceseId){
                let route = "{{ route('absencese.getData') }}";
                let token = "{{ csrf_token()}}";
                $.ajax({
                    url: route,
                    type: 'POST',
                    data: {
                        _token:token,
                        absencese_id: absenceseId,
                    },
                    success: function(response) {
                        var newOption = new Option(`${response.user.text}`, response.user.id, true, true);
                        $('.absentUser').append(newOption).trigger('change');
                        $("#addAbsentForm").attr('action', '{{ url('/') }}/absencese/update/' + response.id);
                        $('#absent_method').val('put')
                        $(".invalid-feedback").remove()
                        $("#addAbsentForm .is-invalid").removeClass('is-invalid');
                        $("#absenceseModal .modal-footer > button").text('Edit');
                        $("#absenceseModal #deleteAbsentForm").css('display', 'block');
                        $("#absenceseModal #deleteAbsentForm").attr('action', '{{ url('/') }}/absencese/'+ response.id);
                        $("#absenceseModal").modal('show');
                    },
                    error: function(xhr) {
                        //Do Something to handle error
                    }
                });
            }
            else{
                var newOption = new Option("{{ __('words.choose_username') }}", 0, true, true);
                $('.absentUser').append(newOption).trigger('change');
                $("#addAbsentForm").attr('action', '{{ route('absencese.store') }}');
                $('#absent_method').val('')
                $(".invalid-feedback").remove()
                $("#addAbsentForm .is-invalid").removeClass('is-invalid');
                $("#absenceseModal .modal-footer > button").text('Save');
                $("#absenceseModal #deleteAbsentForm").css('display', 'none');
                $("#absenceseModal #deleteAbsentForm").attr('action', '');
                $("#absenceseModal").modal('show');
            }
        })

        $('.userSelect').select2({
            placeholder: "{{ __('words.choose_username') }}",
            language: "ar",
            searchInputPlaceholder: 'Enter username..',
            width: '100%',
            @error('user_id')
            dropdownCssClass : 'error',
            selectionCssClass: 'error',
            @enderror
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

        $('.absentUser').select2({
            placeholder: "{{ __('words.choose_username') }}",
            searchInputPlaceholder: 'Enter username..',
            width: '100%',
            @error('absent_user_id')
            dropdownCssClass : 'error',
            selectionCssClass: 'error',
            @enderror
            dropdownParent: $("#absenceseModal"),
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

        $('.absentUser').on('select2:select', function (e) {
            if($('#absent_user_id').val() == 0){
                $("#absenceseModal .modal-footer > button").attr('disabled', 'disabled');
            }else{
                $("#absenceseModal .modal-footer > button").removeAttr('disabled');
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
                $("#bus_no").children().remove();
                var newOption = new Option(`${opt.busNo ?? ""}`, opt.id, true, true);
                $('.busSelect').append(newOption).trigger('change');
            }
            var $opt = $(
                '<span>' + opt.text + '</span>'
            );
            return $opt;
        }

        $('.userSelect').on('select2:selecting', function (e) {
            if($('#user_id').children().length > 2){
                $('#user_id').children()[1].remove();
                console.log('2');
            }
        });

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

        $("tbody th").on('click', function(){
            let date = $(this).parent().attr("date")
            window.location.href = "{{ url('/') . "/daily-jobs/" }}" + date
        });

        $('.helperSelect').select2({
            placeholder: "{{ __('words.choose_username') }}",
            language: "ar",
            searchInputPlaceholder: 'Enter username..',
            @error('helper_id')
            dropdownCssClass : 'error',
            selectionCssClass: 'error',
            @enderror
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
