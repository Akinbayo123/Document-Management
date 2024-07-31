<!-- resources/views/documents/view.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>{{ $document->title }}</h1>
    <p>{{ $document->description }}</p>
    <a href="{{ asset('storage/' . $document->file_path) }}" class="btn btn-primary">Download Document</a>
</div>
@endsection