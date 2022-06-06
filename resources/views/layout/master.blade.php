<!doctype html>
<html class="no-js" lang="en">
@include('layout.header')
<body class="open pr-0">

    <div class="preloader">
        <div class="box">
            <div class="loader-14"></div>
        </div>
    </div>
    <!-- Left Panel -->
    @include("layout.aside")
    <!-- Left Panel -->

    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        @include("layout.main-header")
        <!-- Header-->

        <!-- main content -->
        <div class="main-content">
            @yield('content')
        </div>
        <!-- main content -->
    </div>
    <!-- Right Panel -->
    @include("layout.scripts")
</body>
</html>
