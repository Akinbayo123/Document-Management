@extends('layouts.admin')

@section('content')
@php
$i=20;
$page=@$_GET['page'];
if(!$page){
$page=1;
}
$serial_no= $i*($page-1)+1;
@endphp
<div class="container mt-5">
    <div class="row justify-content-between align-items-center mb-3">
        <div class="col">
            <h1>Documents</h1>
        </div>
        <div class="col text-end">
            <a href="{{ route('documents.create') }}" class="btn btn-primary">Upload New Document</a>
        </div>
    </div>

    <div class="row justify-content-end mb-3">
        <div class="col-md-6">
            <form action="{{ route('documents.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search documents..."
                        value="{{ request('search') }}">
                    <button type="submit" class="btn btn-secondary">Search</button>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Uploaded By</th>
                    <th>QR Code</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($documents as $document)
                <tr>
                    <td>{{ $serial_no++ }}</td>
                    <td>{{ $document->title }}</td>
                    <td>{{ $document->description }}</td>
                    <td>{{ $document->user->name }}</td>
                    <td>
                        <div style="height: 60p!important; width: 60px;">
                            {!! DNS2D::getBarcodeHTML(route('documents.open', $document->id), 'QRCODE', 3, 3) !!}
                        </div>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="dropdown">
                                <span class="fs--1">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="18px" height="18px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"></rect>
                                            <circle fill="#ffffff" cx="5" cy="12" r="2"></circle>
                                            <circle fill="#ffffff" cx="12" cy="12" r="2"></circle>
                                            <circle fill="#ffffff" cx="19" cy="12" r="2"></circle>
                                        </g>
                                    </svg>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end border py-0">
                                <div class="py-2">
                                    <a href="{{ route('documents.show', $document->id) }}"
                                        class="dropdown-item text-info">View</a>
                                    <a href="{{ route('documents.edit', $document->id) }}"
                                        class="dropdown-item text-warning">Edit</a>
                                    <form action="{{ route('documents.destroy', $document->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger"
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="fw-bold text-center mt-4 mb-3">
                        No record found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {!! $documents->withQueryString()->links('pagination::bootstrap-5') !!}
    </div>
</div>

@endsection