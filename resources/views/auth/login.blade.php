<x-guest-layout>
    <div class="container">
        <div class="">
            <div class="m-x-auto pull-xs-none vamiddle">
                <div class="card-group row">
                    <div class="col-sm-7 card p-0">
                        <div class="card-block">
                            <h1 class="main-title">Login</h1>
                            <p class="text-muted secondary-text">Use your email and password to get in.</p>
                            @error("email")
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>OOPS!</strong> {{ $message }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @enderror
                            <form method="post" action="{{ route('login') }}">
                                @csrf
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="user-icon"><i class="fa fa-user"></i></span>
                                    </div>
                                    <input type="text" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="user-icon" required autofocus>
                                </div>
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="lock-icon"><i class="fa fa-lock"></i></span>
                                    </div>
                                    <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="lock-icon" required autocomplete="current-password">
                                </div>
                                <div class="row m-0">
                                    <div class="col-sm-6 pl-0">
                                        <button type="submit" class="btn btn-info p-x-2 login-btn">
                                            <i class="fa fa-sign-in pr-2"></i>Login
                                        </button>
                                    </div>
                                    <div class="col-sm-6 text-right p-0">
                                        <a class="btn btn-link text-info p-x-0 pr-0" href="{{ route('password.request') }}">Forget Password?</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-5 card card-inverse card-primary p-3 img-card" style="width:44%">
                        <div class="card-block text-xs-center img-section">
                            <div>
                                <h2 style="letter-spacing: 5px;"><span>T</span>RANSPORT</h2>
                                <h2 style="letter-spacing: 3px;"><span>M</span>ANAGEMENT</h2>
                                <h2><span>S</span>YSTEM</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        $('.alert').alert()
    </script>
</x-guest-layout>