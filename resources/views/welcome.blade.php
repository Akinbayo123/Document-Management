@extends('layouts.app')

@section('content')


<div class="hero vh-100 d-flex align-items-center" id="home">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 mx-auto text-center">
                <h1 class="display-4 text-white">Streamline Your Document Workflow Today</h1>
                <p class="text-white my-3">We make it easy for you to organize and manage your documents conveniently
                    from any device.</p>
                <a href="{{ route('login') }}" class="btn me-2 btn-primary">Get Started</a>

            </div>
        </div>
    </div>
</div>
@endsection