@extends('layouts.app')

@section('title')
    All Users | {{ config('app.name', 'PM Software') }}
@endsection

@section('page-specific-head-scripts')
	<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    @include('users.users.messages')

    {{-- Breadcrumb --}}
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a class="text-dark" href="{{ route('dashboard') }}">DASHBOARD</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="text-dark" href="{{ route('users.index') }}">USERS</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">ALL USERS ({{ $users_not_for_super->count() }})</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            @can('create users')
                {{-- New User Button --}}
                <button type="button" class="btn btn-outline-primary" title="Add" data-bs-toggle="modal" data-bs-target="#userAddNewButton">
                    ADD NEW
                </button>
                {{-- New User Modal --}}
                <div class="modal" id="userAddNewButton" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form class="d-inline" action="{{ route('users.store') }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Add User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Frank William">
                                    </div>
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" name="username" id="username" placeholder="frank-william">
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone_no" class="form-label">Phone No.</label>
                                        <input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="0512345678">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="frank@gmail.com">
                                    </div>
                                    <div class="mb-3">
                                        <label for="role" class="form-label">Role</label>
                                        <select class="form-select form-select-sm" name="role" id="role" aria-label="Select Role">
                                            <option value="">Select Role</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                                                @endforeach
                                          </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" id="password">
                                    </div>
                                    <div>
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Add New</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table align-middle table-hover table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Last Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (auth()->user()->roles[0]->name == 'super-admin' ? $users_for_super : $users_not_for_super; as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><a class="text-dark cursor-pointer" title="View" data-bs-toggle="modal" data-bs-target="#userDisplayButton{{ $user->id }}">{{ $user->name }}</a></td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach ($user->roles as $role)
                                        <span>{{ ucfirst($role->name) }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @if(Cache::has('user-is-online-' . $user->id))
                                        <span class="text-success">Online</span>
                                    @else
                                        <span class="text-secondary">Offline</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $user->last_seen ? Carbon\Carbon::parse($user->last_seen)->diffForHumans() : '-' }}
                                </td>
                                <td>
                                    {{-- View User Button --}}
                                    <a class="btn btn-outline-dark" title="View" data-bs-toggle="modal" data-bs-target="#userDisplayButton{{ $user->id }}">
                                        <i class='bx bx-show me-0'></i>
                                    </a>
                                    {{-- View User Modal --}}
                                    <div class="modal" id="userDisplayButton{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{ $user->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-2"><strong>Username:</strong> {{ $user->username }}</div>
                                                    <div class="mb-2"><strong>Phone No.:</strong> {{ $user->phone_no }}</div>
                                                    <div class="mb-2"><strong>Email:</strong> {{ $user->email }}</div>
                                                    <div class="mb-2"><strong>Role:</strong> {{ ucfirst($user->roles[0]->name) }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @can('edit users')
                                        {{-- Edit User Button --}}
                                        <a class="btn btn-outline-primary" title="Edit" data-bs-toggle="modal" data-bs-target="#userEditingButton{{ $user->id }}">
                                            <i class='bx bx-edit-alt me-0'></i>
                                        </a>
                                        {{-- Edit User Modal --}}
                                        <div class="modal" id="userEditingButton{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form class="d-inline" action="{{ route('users.update', $user->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit User</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="name" class="form-label">Name</label>
                                                                <input type="text" class="form-control" name="name" id="name" placeholder="Frank William" value="{{ $user->name }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="username" class="form-label">Username</label>
                                                                <input type="text" class="form-control" name="username" id="username" placeholder="frank-william" value="{{ $user->username }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="phone_no" class="form-label">Phone No.</label>
                                                                <input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="0512345678" value="{{ $user->phone_no }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="email" class="form-label">Email Address</label>
                                                                <input type="email" class="form-control" name="email" id="email" placeholder="frank@gmail.com" value="{{ $user->email }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="role" class="form-label">Role</label>
                                                                <select class="form-select form-select-sm" name="role" id="role" aria-label="Select Role">
                                                                    <option value="{{ $user->roles[0]->name }}">{{ ucfirst($user->roles[0]->name) }} (Current)</option>
                                                                        @foreach (auth()->user()->roles[0]->name == 'super-admin' ? $roles : $roles_excluded_super as $role)
                                                                            <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                                                                        @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="password" class="form-label">New Password</label>
                                                                <input type="password" class="form-control" name="password" id="password">
                                                            </div>
                                                            <div>
                                                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endcan

                                    @can('delete users')
                                        {{-- Button Triger Modal --}}
                                        <button type="button" class="btn btn-outline-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#userDeleteButton{{ $user->id }}">
                                            <i class='bx bx-trash me-0'></i>
                                        </button>
                                        {{-- Modal --}}
                                        <div class="modal" id="userDeleteButton{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form class="d-inline" action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete user</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you would like to delete this user ({{ $user->name }})?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('page-specific-js')
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>
@endsection
