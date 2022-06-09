<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">

        <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="./"><img src="{{ asset("images/logo.svg") }}" alt="Logo"></a>
            <a class="navbar-brand hidden" href="./"><img src="{{ asset("images/logo2.svg") }}" alt="Logo"></a>
        </div>

        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="">
                    <a href="{{ route('dashboard') }}"> <i class="menu-icon fa fa-dashboard"></i>{{ __("words.Dashboard") }}</a>
                </li>
                @if(auth()->user()->role != 0)
                    <li class="menu-item-has-children dropdown">
                        <a href="{{ route('places.index') }}" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="menu-icon fa fa-map-marked-alt"></i>{{ __("words.Places") }}</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-map-marker-alt"></i><a href="{{ route("places.index") }}">{{ __("words.Show Places") }}</a></li>
                            <li><svg id="Layer_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 238.84 341.33"><title>location</title><path d="M-446.35,111.4C-412.7,72-381.93,30.6-357.71-15.36c11-20.81,20.42-42.29,25.3-65.45,8.49-40.24-.54-76.11-27.82-107-17-19.3-38.55-31.25-63.63-36.89-4.9-1.1-10-1.13-14.81-2.63h-22c-2.26,1.62-5,1.27-7.52,1.74-42.56,7.93-72.76,31.86-90.31,71.15-11.34,25.38-12.17,51.92-5.28,78.8,5.41,21.16,14,41,24.14,60.26,24.24,46,55,87.39,88.66,126.78.65.76,1.89,1.24,1.65,2.6H-448C-448.24,112.64-447,112.16-446.35,111.4ZM-462.6-39.48c-2.81.06-3.24-.94-3.22-3.42.1-15,0-30,.1-45,0-2.34-.59-3-2.92-2.91-3.77.08-7.55.09-11.33.09s-7.55,0-11.33,0l-11.5,0c-3.83,0-7.66,0-11.49.06-2,0-2.68-.44-2.65-2.55q.16-14.49,0-29c0-2.28.74-2.71,2.82-2.7,15,.08,30,0,45,.12,2.86,0,3.45-.84,3.43-3.54-.13-14.88,0-29.77-.13-44.66,0-2.49.59-3.17,3.12-3.12q14.16.24,28.32,0c2.42,0,2.91.75,2.89,3-.1,15,0,30-.11,45,0,2.63.67,3.34,3.3,3.32,15-.13,30,0,45-.12,2.32,0,3,.56,2.94,2.92-.14,9.44-.17,18.89,0,28.33.06,2.66-.87,3-3.22,3-15-.1-30,0-45-.12-2.58,0-3.06.72-3,3.13.12,15,0,30,.12,45,0,2.44-.55,3.23-3.11,3.18C-443.94-39.66-453.27-39.68-462.6-39.48Z" transform="translate(568.17 227.33)"/></svg>
                                <a href="{{ route("places.create") }}">{{ __("words.Add Place") }}</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="{{ route('users.index') }}" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="menu-icon fa fa-users"></i>{{ __("words.Users") }}</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-user"></i><a href="{{ route("users.index") }}">{{ __("words.Show Users") }}</a></li>
                            <li><i class="fa fa-user-plus"></i><a href="{{ route("users.create") }}">{{ __("words.Add User") }}</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="{{ route('categories.index') }}" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="menu-icon fa fa-list"></i>{{ __("words.categories") }}</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-eye"></i><a href="{{ route("categories.index") }}">{{ __("words.Show Categories") }}</a></li>
                            <li><i class="fa fa-plus"></i><a href="{{ route("categories.create") }}">{{ __("words.Add Category") }}</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="{{ route('posts.index') }}" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="menu-icon fa fa-copy"></i>{{ __("words.posts") }}</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-file-alt"></i><a href="{{ route("posts.index") }}">{{ __("words.Show posts") }}</a></li>
                            <li><i class="fas fa-file-circle-plus"></i><a href="{{ route("posts.create") }}">{{ __("words.Add post") }}</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="{{ route('uploadfiles.index') }}" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="menu-icon fa fa-file-pdf"></i>{{ __("words.Uploaded_files") }}</a>
                        <ul class="sub-menu children dropdown-menu" style="right: -189px; !important;">
                            <li><i class="fa fa-file-circle-check"></i><a href="{{ route("uploadfiles.index") }}">{{ __("words.Show Uploaded_files") }}</a></li>
                            <li><i class="fa fa-file-user"></i><a href="{{ route("uploadfiles.selectUsers") }}">{{ __("words.Select User") }}</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="{{ route('events.index') }}" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="menu-icon fa fa-calendar-days"></i>{{ __("words.Events") }}</a>
                        <ul class="sub-menu children dropdown-menu">
                            @if(auth()->user()->role != 0)
                                <li><i class="fa fa-calendar-check"></i><a href="{{ route("events.index") }}">{{ __("words.Show events") }}</a></li>
                            @else
                                <li><i class="fa fa-calendar-plus"></i><a href="{{ route("events.index") }}">{{ __("words.add event") }}</a></li>
                            @endif
                        </ul>
                    </li>
                    <li class="">
                        <a href="{{ route('totalHours.index') }}"> <i class="menu-icon fa fa-clock"></i>{{ __("words.Total Hours") }}</a>
                    </li>
                    <li class="">
                        <a href="{{ route('jobs.index') }}"> <i class="menu-icon fa fa-calendar-week"></i>{{ __("words.Week Jobs") }}</a>
                    </li>
                @else
                    <li class="">
                        <a href="{{ route('posts.index') }}"> <i class="menu-icon fa fa-file-alt"></i>{{ __("words.Show posts") }}</a>
                    </li>
                    <li class="">
                        <a href="{{ route('uploadfiles.getUserFiles', auth()->id()) }}"> <i class="menu-icon fa fa-file-pdf"></i>{{ __("words.Uploaded_files") }}</a>
                    </li>
                    <li class="">
                        <a href="{{ route('events.index') }}"> <i class="menu-icon fa fa-calendar-days"></i>{{ __("words.Events") }}</a>
                    </li>
                    <li class="">
                        <a href="{{ route('jobs.weekJobsIndex') }}"> <i class="menu-icon fa fa-calendar-week"></i>{{ __("words.Week Jobs") }}</a>
                    </li>
                    <li class="">
                        <a href="{{ route('jobs.dayJobs') }}"> <i class="menu-icon fa fa-calendar-day"></i>{{ __("words.daily Jobs") }}</a>
                    </li>
                @endif
{{--                <h3 class="menu-title">UI elements</h3><!-- /.menu-title -->--}}
{{--                <li class="menu-item-has-children dropdown">--}}
{{--                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i>Components</a>--}}
{{--                    <ul class="sub-menu children dropdown-menu">--}}
{{--                        <li><i class="fa fa-puzzle-piece"></i><a href="">Buttons</a></li>--}}
{{--                        <li><i class="fa fa-id-badge"></i><a href="">Badges</a></li>--}}
{{--                        <li><i class="fa fa-bars"></i><a href="">Tabs</a></li>--}}
{{--                        <li><i class="fa fa-share-square-o"></i><a href="">Social Buttons</a></li>--}}
{{--                        <li><i class="fa fa-id-card-o"></i><a href="">Cards</a></li>--}}
{{--                        <li><i class="fa fa-exclamation-triangle"></i><a href="">Alerts</a></li>--}}
{{--                        <li><i class="fa fa-spinner"></i><a href="">Progress Bars</a></li>--}}
{{--                        <li><i class="fa fa-fire"></i><a href="">Modals</a></li>--}}
{{--                        <li><i class="fa fa-book"></i><a href="">Switches</a></li>--}}
{{--                        <li><i class="fa fa-th"></i><a href="">Grids</a></li>--}}
{{--                        <li><i class="fa fa-file-word-o"></i><a href="">Typography</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
{{--                <li class="menu-item-has-children dropdown">--}}
{{--                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-table"></i>Tables</a>--}}
{{--                    <ul class="sub-menu children dropdown-menu">--}}
{{--                        <li><i class="fa fa-table"></i><a href="">Basic Table</a></li>--}}
{{--                        <li><i class="fa fa-table"></i><a href="">Data Table</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
{{--                <li class="menu-item-has-children dropdown">--}}
{{--                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-th"></i>Forms</a>--}}
{{--                    <ul class="sub-menu children dropdown-menu">--}}
{{--                        <li><i class="menu-icon fa fa-th"></i><a href="">Basic Form</a></li>--}}
{{--                        <li><i class="menu-icon fa fa-th"></i><a href="">Advanced Form</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}

{{--                <h3 class="menu-title">Icons</h3><!-- /.menu-title -->--}}

{{--                <li class="menu-item-has-children dropdown">--}}
{{--                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-tasks"></i>Icons</a>--}}
{{--                    <ul class="sub-menu children dropdown-menu">--}}
{{--                        <li><i class="menu-icon fa fa-fort-awesome"></i><a href="">Font Awesome</a></li>--}}
{{--                        <li><i class="menu-icon ti-themify-logo"></i><a href="">Themefy Icons</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
{{--                <li>--}}
{{--                    <a href=""> <i class="menu-icon ti-email"></i>Widgets </a>--}}
{{--                </li>--}}
{{--                <li class="menu-item-has-children dropdown">--}}
{{--                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-bar-chart"></i>Charts</a>--}}
{{--                    <ul class="sub-menu children dropdown-menu">--}}
{{--                        <li><i class="menu-icon fa fa-line-chart"></i><a href="">Chart JS</a></li>--}}
{{--                        <li><i class="menu-icon fa fa-area-chart"></i><a href="">Flot Chart</a></li>--}}
{{--                        <li><i class="menu-icon fa fa-pie-chart"></i><a href="">Peity Chart</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}

{{--                <li class="menu-item-has-children dropdown">--}}
{{--                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-area-chart"></i>Maps</a>--}}
{{--                    <ul class="sub-menu children dropdown-menu">--}}
{{--                        <li><i class="menu-icon fa fa-map-o"></i><a href="">Google Maps</a></li>--}}
{{--                        <li><i class="menu-icon fa fa-street-view"></i><a href="">Vector Maps</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
{{--                <h3 class="menu-title">Extras</h3><!-- /.menu-title -->--}}
{{--                <li class="menu-item-has-children dropdown">--}}
{{--                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-glass"></i>Pages</a>--}}
{{--                    <ul class="sub-menu children dropdown-menu">--}}
{{--                        <li><i class="menu-icon fa fa-sign-in"></i><a href="">Login</a></li>--}}
{{--                        <li><i class="menu-icon fa fa-sign-in"></i><a href="">Register</a></li>--}}
{{--                        <li><i class="menu-icon fa fa-paper-plane"></i><a href="">Forget Pass</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>
