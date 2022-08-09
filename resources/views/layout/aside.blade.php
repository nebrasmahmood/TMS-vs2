<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">

        <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="./">
                TMS
                {{-- <img src="{{ asset("images/logo.svg") }}" alt="Logo"> --}}
            </a>
            <a class="navbar-brand hidden" href="./">
                {{-- <img src="{{ asset("images/logo2.svg") }}" alt="Logo"> --}}
                T
            </a>
        </div>

        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="">
                    <a href="{{ route('dashboard') }}"> <i class="menu-icon fa fa-dashboard"></i>{{ __("nl-words.Dashboard") }}</a>
                </li>
                @if(auth()->user()->role != 0)
                    <li class="menu-item-has-children dropdown">
                        <a href="{{ route('places.index') }}" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="menu-icon fa fa-map-marked-alt"></i>{{ __("nl-words.Places") }}</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-map-marker-alt"></i><a href="{{ route("places.index") }}">{{ __("nl-words.Show Places") }}</a></li>
                                <li><i class="fa fa-plus"></i><a href="{{ route("places.create") }}">{{ __("nl-words.Add Place") }}</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="{{ route('users.index') }}" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="menu-icon fa fa-users"></i>{{ __("nl-words.Users") }}</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-user"></i><a href="{{ route("users.index") }}">{{ __("nl-words.Show Users") }}</a></li>
                            <li><i class="fa fa-user-plus"></i><a href="{{ route("users.create") }}">{{ __("nl-words.Add User") }}</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="{{ route('categories.index') }}" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="menu-icon fa fa-list"></i>{{ __("nl-words.categories") }}</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-eye"></i><a href="{{ route("categories.index") }}">{{ __("nl-words.Show Categories") }}</a></li>
                            <li><i class="fa fa-plus"></i><a href="{{ route("categories.create") }}">{{ __("nl-words.Add Category") }}</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="{{ route('posts.index') }}" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="menu-icon fa fa-copy"></i>{{ __("words.posts") }}</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-file-alt"></i><a href="{{ route("posts.index") }}">{{ __("nl-words.Show posts") }}</a></li>
                            <li><i class="fas fa-file-circle-plus"></i><a href="{{ route("posts.create") }}">{{ __("nl-words.Add post") }}</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="{{ route('uploadfiles.index') }}" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="menu-icon fa fa-file-pdf"></i>{{ __("nl-words.Uploaded_files") }}</a>
                        <ul class="sub-menu children dropdown-menu" style="right: -189px; !important;">
                            <li><i class="fa fa-file-circle-check"></i><a href="{{ route("uploadfiles.index") }}">{{ __("nl-words.Show Uploaded_files") }}</a></li>
                            <li><i class="fa fa-user"></i><a href="{{ route("uploadfiles.selectUsers") }}">{{ __("nl-words.Select User") }}</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="{{ route('events.index') }}" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="menu-icon fa fa-calendar-days"></i>{{ __("nl-words.Events") }}</a>
                        <ul class="sub-menu children dropdown-menu">
                            @if(auth()->user()->role != 0)
                                <li><i class="fa fa-calendar-check"></i><a href="{{ route("events.index") }}">{{ __("nl-words.Show events") }}</a></li>
                            @else
                                <li><i class="fa fa-calendar-plus"></i><a href="{{ route("events.index") }}">{{ __("nl-words.add event") }}</a></li>
                            @endif
                        </ul>
                    </li>
                    <li class="">
                        <a href="{{ route('totalHours.index') }}"> <i class="menu-icon fa fa-clock"></i>{{ __("nl-words.Total Hours") }}</a>
                    </li>
                    <li class="">
                        <a href="{{ route('jobs.index') }}"> <i class="menu-icon fa fa-calendar-week"></i>{{ __("nl-words.Week Jobs") }}</a>
                    </li>
                @else
                    <li class="">
                        <a href="{{ route('posts.index') }}"> <i class="menu-icon fa fa-file-alt"></i>{{ __("nl-words.Show posts") }}</a>
                    </li>
                    <li class="">
                        <a href="{{ route('uploadfiles.getUserFiles', auth()->id()) }}"> <i class="menu-icon fa fa-file-pdf"></i>{{ __("nl-words.Uploaded_files") }}</a>
                    </li>
                    <li class="">
                        <a href="{{ route('events.index') }}"> <i class="menu-icon fa fa-calendar-days"></i>{{ __("nl-words.Events") }}</a>
                    </li>
                    <li class="">
                        <a href="{{ route('jobs.weekJobsIndex') }}"> <i class="menu-icon fa fa-calendar-week"></i>{{ __("nl-words.Week Jobs") }}</a>
                    </li>
{{--                    <li class="">--}}
{{--                        <a href="{{ route('jobs.dayJobs') }}"> <i class="menu-icon fa fa-calendar-day"></i>{{ __("words.daily Jobs") }}</a>--}}
{{--                    </li>--}}
                @endif
            </ul>
        </div>
    </nav>
</aside>
