@extends('layouts.app')

@section('title')
    {{ $user->name }} | {{ config('app.name', 'PM Software') }}
@endsection

@section('content')
    {{-- Breadcrumb --}}
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a class="text-dark" href="{{ route('dashboard') }}">DASHBOARD</a>
                    </li>
                    <li class="breadcrumb-item active text-uppercase" aria-current="page">{{ $user->username }}</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Main Profile --}}
    <div class="container">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center pt-3">
                                <img src="{{ $user->profile_picture ? $user->profile_picture : asset('images/default/default-profile.png') }}" alt="Admin" class="rounded-circle p-1 bg-primary" width="110" height="110">
                                <div class="mt-3">
                                    <h4>{{ $user->name }}</h4>
                                    <p class="text-secondary mb-1">{{ $user->phone_no }}</p>
                                    <p class="text-muted font-size-sm">{{ $user->address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    {{-- Update Profile Details --}}
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('profile.update', $user->username) }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" name="name" value="{{ $user->name }}" placeholder="Eg. John Doe" />
                                    </div>
                                </div>

                                {{-- <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Username</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input disabled type="text" class="form-control" name="username" value="{{ $user->username }}" placeholder="Eg. johndoe" />
                                    </div>
                                </div> --}}

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Phone Number</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" name="phone_no" value="{{ $user->phone_no }}" placeholder="Eg. +971 12345 6789" />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" name="email" value="{{ $user->email }}" placeholder="Eg. johndoe@example.com" />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Address</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" name="address" value="{{ $user->address }}" placeholder="Eg. Dubai, UAE" />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Profile Picture</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="file" class="form-control" name="profile_picture" value="{{ $user->profile_picture }}" />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="submit" class="btn btn-primary px-4" value="Update Profile" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Update Password --}}
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('profile.updatePassword', $user->username) }}" method="POST">
                                @csrf

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">{{ __('Current Password') }}</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <div class="input-group" id="show_hide_password">
                                            <input type="password" class="form-control @error('current_password') border border-danger @enderror" name="current_password" id="current_password" placeholder="Current Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                        </div>
                                        @error('current_password')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">{{ __('New Password') }}</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <div class="input-group" id="show_hide_password_new">
                                            <input type="password" class="form-control @error('password') border border-danger @enderror" name="password" id="password" placeholder="New Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                        </div>
                                        @error('password')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">{{ __('Confirm Password') }}</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <div class="input-group" id="show_hide_password_new">
                                            <input type="password" class="form-control @error('password_confirmation') border border-danger @enderror" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
                                        </div>
                                        @error('password_confirmation')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="submit" class="btn btn-primary px-4" value="Change Password" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-specific-js')
    {{-- Password Show & Hide JS --}}
	<script>
		$(document).ready(function () {
			$("#show_hide_password a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
			});

            $("#show_hide_password_new a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password_new input').attr("type") == "text") {
					$('#show_hide_password_new input').attr('type', 'password');
					$('#show_hide_password_new i').addClass("bx-hide");
					$('#show_hide_password_new i').removeClass("bx-show");
				} else if ($('#show_hide_password_new input').attr("type") == "password") {
					$('#show_hide_password_new input').attr('type', 'text');
					$('#show_hide_password_new i').removeClass("bx-hide");
					$('#show_hide_password_new i').addClass("bx-show");
				}
			});
		});
	</script>
@endsection
