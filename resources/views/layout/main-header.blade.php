<header id="header" class="header">

    <div class="header-menu">

        <div class="col-sm-7 d-flex">
            <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa-align-left"></i></a>
            <div class="header-left">
                <button class="search-trigger"><i class="fa fa-search"></i></button>

                <div class="form-inline">
                    <form class="search-form">
                        <input class="form-control mr-sm-2" type="text" placeholder="Search ..." aria-label="Search">
                        <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="user-area dropdown float-right">
                <a href="#" class="dropdown-toggle user-settings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-caret-down" style="margin-left: 5px;"></i>
                    <img class="user-avatar rounded-circle" src="{{ asset(auth()->user()->profile_photo) }}">
                </a>
                <div class="user-menu dropdown-menu">
                    <a class="nav-link" href="#"><i class="fa fa -cog"></i>Settings</a>
                    <form id="logoutForm" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            <i class="fa fa-power -off"></i>Logout
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
