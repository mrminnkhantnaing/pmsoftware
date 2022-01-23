@extends('layouts.auth')

@section('title')
    Login | {{ config('app.name', 'PM Software') }}
@endsection

@section('content')
    <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
        <div class="container-fluid">
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                <div class="col mx-auto">
                    <div class="mb-4 text-center">
                        <a href="{{ route('dashboard') }}">
                            <img src="{{ asset('images/default/tkd_logo_element.png') }}" width="80" alt="the khant digital" />
                        </a>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-primary border-0 bg-primary alert-dismissible fade show">
									<div class="text-white">{{ session('status') }}</div>
								</div>
                            @endif
                            <div class="border p-4 rounded">
                                <div class="text-center">
                                    <h5 class="">{{ __('Reset Password') }}</h5>
                                </div>
                                <div class="form-body">
                                    <form class="row g-3" method="POST" action="{{ route('password.email') }}">
                                        @csrf

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
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary"><i class="bx bxs-lock-open"></i>{{ __('Send Password Reset Link') }}</button>
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
