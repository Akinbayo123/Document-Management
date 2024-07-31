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
            <h1>Users</h1>
        </div>
        <div class="col text-end">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Create User</a>
        </div>
    </div>
    <div class="row justify-content-end mb-3">
        <div class="col-md-6">
            <form action="{{ route('admin.users.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search Users..."
                        value="{{ request('search') }}">
                    <button type="submit" class="btn btn-secondary">Search</button>
                </div>
            </form>
        </div>
    </div>
    <div class="table-responsive border">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $serial_no++ }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}</td>

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
                                    <a href="{{ route('admin.users.show', $user->id) }}"
                                        class="dropdown-item text-info">View</a>
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="dropdown-item text-warning">Edit</a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
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
                @endforeach
            </tbody>
        </table>
        {!! $users->withQueryString()->links('pagination::bootstrap-5') !!}
    </div>
</div>

@endsection