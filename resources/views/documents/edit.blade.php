<!-- resources/views/documents/edit.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h3 class="mb-0">Edit Document</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('documents.update', $document->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="title" class="form-label fw-bold">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $document->title }}"
                                required>
                            @error('title')
                            <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea name="description" class="form-control"
                                rows="4">{{ $document->description }}</textarea>
                            @error('description')
                            <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="file" class="form-label fw-bold">File</label>
                            <input type="file" name="file" class="form-control">
                            <small class="form-text text-muted">Leave blank if you don't want to change the file</small>
                            @error('file')
                            <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection