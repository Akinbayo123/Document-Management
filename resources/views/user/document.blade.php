@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-between align-items-center mb-3">
        <div class="col">
            <h1>Documents</h1>
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
    <div class="row">

        @forelse ($documents as $document)
        <div class="col-md-3 mb-4">
            <div class="card">
                <div>
                    <img src="image/pdf_logo.png" class="" alt="Document Preview" height="220px">
                </div>


                <div class="card-body">
                    <h5 class="card-title fw-bold">{{ $document->title }}</h5>
                    <p class="card-text"><span class="fw-bold">Description:</span> {{ $document->description }}</p>
                    {{-- <div style="height: 60px; width: 60px; margin-bottom: 1rem;">
                        {!! DNS2D::getBarcodeHTML(route('documents.open', $document->id), 'QRCODE', 3, 3) !!}
                    </div> --}}
                    <div style="display: flex;
            justify-content: flex-end;">
                        <a href="{{ route('documents.show', $document->id) }}" class="btn btn-primary">View</a>
                    </div>

                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p class="fw-bold text-center mt-4 mb-3">
                No record found
            </p>
        </div>
        @endforelse
    </div>
    {!! $documents->withQueryString()->links('pagination::bootstrap-5') !!}
</div>



@endsection