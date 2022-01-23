@extends('layouts.auth')

@section('title')
    Register | {{ config('app.name', 'PM Software') }}
@endsection

@section('content')
    <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
        <div class="container-fluid">
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                <div class="col mx-auto">
                    <div class="mb-4 text-center">
                        <img src="{{ asset('images/default/tkd_logo_element.png') }}" width="80" alt="the khant digital" />
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="border p-4 rounded">
                                <div class="text-center">
                                    <h5 class="">{{ __('Sign Up') }}</h5>
                                </div>
                                <div class="form-body">
                                    <form class="row g-3" method="POST" action="{{ route('register') }}">
                                        @csrf

                                        <div class="col-12">
                                            <label for="name" class="form-label">{{ __('Name') }}</label>
                                            <input type="name" class="form-control @error('name') border border-danger @enderror" name="name" id="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Name">
                                            @error('name')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                            <input type="email" class="form-control @error('email') border border-danger @enderror" name="email" id="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email Address">
                                            @error('email')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <label for="password" class="form-label">{{ __('Enter Password') }}</label>
                                            <div class="input-group" id="show_hide_password">
                                                <input type="password" class="form-control border-end-0 @error('password') border border-danger @enderror" name="password" id="password" placeholder="Enter Password" required autocomplete="new-password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                            </div>
                                            @error('password')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                                            <div class="input-group" id="show_hide_password">
                                                <input type="password" class="form-control @error('password-confirm') border border-danger @enderror" name="password_confirmation" id="password-confirm" placeholder="Confirm Password" required autocomplete="new-password">
                                            </div>
                                            @error('password-confirm')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <a href="{{ route('login') }}">{{ __('Have an account? Login.') }}</a>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            @if (Route::has('password.request'))
                                                <a href="{{ route('password.request') }}">
                                                    {{ __('Forgot Your Password?') }}
                                                </a>
                                            @endif
                                        </div>

                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary"><i class="bx bxs-lock-open"></i>{{ __('Sign Up') }}</button>
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
    </div>
@endsection
