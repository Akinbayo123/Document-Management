<!-- resources/views/documents/show.blade.php -->
@extends(auth()->user()->role == 'student' ? 'layouts.app' : 'layouts.admin')

@section('content')

<div class="container my-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title">{{ $document->title }}</h1>

                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe src="{{ Storage::url($document->file_path) }}" class="embed-responsive-item"
                            style="width:100%; height:600px;" frameborder="0">
                            Your browser does not support iframes.
                        </iframe>
                    </div>
                    <div class="d-flex">
                        <a href="{{ Storage::url($document->file_path) }}" class="btn btn-primary"
                            download="{{ $document->title }}">Download ({{ $fileSizeFormatted }})</a>
                    </div>
                    {{-- <p>{{ Storage::url($document->file_path) }}</p> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection