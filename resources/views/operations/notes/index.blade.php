@extends('layouts.app')

@section('title')
    Notes | {{ config('app.name', 'PM Software') }}
@endsection

@section('content')
    @error('title')
        <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
            <div class="d-flex align-items-center">
                <div class="font-35 text-white"><i class='bx bx-x-circle' ></i>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0 text-white">Error Alert</h6>
                    <div class="text-white">{{ $message }}</div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror
    {{-- Breadcrumb --}}
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a class="text-dark" href="{{ route('dashboard') }}">DASHBOARD</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="text-dark" href="{{ route('notes.index') }}">NOTE</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">ALL NOTES ({{ $notes->count() }})</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            {{-- View Modal Trigger --}}
            <a type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addModal">ADD NEW</a>
        </div>
    </div>

    {{-- Notes --}}
    <div class="card">
        <div class="card-body">
            <div class="row">
                @foreach ($notes as $note)
                    <div class="div col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">
                                    <h6>{{ $note->title }}</h6>
                                </div>
                                <small class="d-block mb-2"><em>Updated at {{ $note->updated_at }}</em></small>
                                <p>{{ substr($note->body, 0, 100) }}</p>

                                {{-- View Modal Trigger --}}
                                <a type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal{{ $note->id }}">View</a>
                                {{-- View Modal Trigger --}}
                                <a type="button" class="btn btn-outline-dark btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $note->id }}">Edit</a>
                                {{-- View Modal Trigger --}}
                                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $note->id }}">Delete</button>

                                {{-- View Modal --}}
                                <div class="modal fade" id="viewModal{{ $note->id }}" tabindex="-1" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">{{ $note->title }}</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div>
                                                    {{ $note->body }}
                                                </div>
                                                <small class="d-block mt-2"><strong><em>Updated at {{ $note->updated_at }}</em></strong></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Edit Modal --}}
                                <div class="modal fade" id="editModal{{ $note->id }}" tabindex="-1" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">{{ $note->title }}</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('notes.update', $note->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="col-12 mb-3">
                                                        <label for="title" class="form-label">Title</label>
                                                        <input type="text" name="title" id="title" class="form-control" placeholder="Eg. Note one" value="{{ $note->title }}">
                                                    </div>
                                                    <div class="col-12 mb-3">
                                                        <label for="body" class="form-label">Description</label>
                                                        <textarea class="form-control" id="body" name="body" placeholder="This is my note one..." rows="6">{{ $note->body }}</textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-dark">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Delete Modal --}}
                                <div class="modal fade" id="deleteModal{{ $note->id }}" tabindex="-1" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form action="{{ route('notes.destroy', $note->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-header">
                                                    <h6 class="modal-title">Delete {{ $note->title }}</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div>Are you sure you want to delete this? Please make sure that you will not be able to get this data again after you delete!</div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
                {{-- Add Modal --}}
                <div class="modal fade" id="addModal" tabindex="-1" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title">Add A New Note</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('notes.store') }}" method="POST">
                                    @csrf
                                    <div class="col-12 mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" name="title" id="title" class="form-control" placeholder="Eg. Note one">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="body" class="form-label">Description</label>
                                        <textarea class="form-control" id="body" name="body" placeholder="This is my note one..." rows="6"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-dark">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
