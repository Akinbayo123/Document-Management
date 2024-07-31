<!-- resources/views/documents/show.blade.php -->
@extends(auth()->user()->role == 'student' ? 'layouts.app' : 'layouts.admin')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- PDF Preview Image -->
                    <div class="text-center mb-3">
                        <img src="image/pdf_logo.png" class="img-fluid" alt="Document Preview"
                            style="max-height: 200px;">
                    </div>
                    <div class="text-center">
                        <!-- Document Title -->
                        <h1 class="card-title text-center mb-3">{{ $document->title }}</h1>

                        <!-- Document Description -->
                        <p class="card-text mb-2 h5"><span class="fw-bold">Description:</span> {{ $document->description
                            }}
                        </p>

                        <!-- Uploaded By -->
                        <p class="card-text mb-4 h5"><strong>Uploaded by:</strong> {{ $document->user->name }}</p>

                    </div>
                    <!-- QR Code and Instruction -->
                    <div class=" mb-4 justify-content-center d-flex align-items-center">
                        {!! DNS2D::getBarcodeHTML(route('documents.open', $document->id), 'QRCODE', 4, 3) !!}
                    </div>
                    <p class="text-center">(Scan Document to open)</p>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('documents.open', $document->id) }}" class="btn btn-primary me-2">Open
                            Document</a>
                        <a href="{{ Storage::url($document->file_path) }}" class="btn btn-secondary"
                            download="{{ $document->title }}">Download ({{ $fileSizeFormatted }})</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection