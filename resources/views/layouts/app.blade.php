<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Management System</title>
    <base href="/public">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="butterup-main/butterup.min.css">
    <link rel="stylesheet" href="resources/sass/app.scss">

    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}

</head>

<body>

    <div id="app">
        <nav class="navbar navbar-expand-lg py-3 sticky-top navbar-light bg-white">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img src="image/logo1.png" width="100px" height="60px" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">

                        @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('documentss.index') }}">Documents</a>
                        </li>


                        <li class=" nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                My Account
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

                                <li><a class="dropdown-item" href="{{ route('profile.index') }}">Profile</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item">Logout</button>
                                    </form>
                                </li>

                            </ul>
                        </li>
                        @endauth
                        @if (!Auth::user())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        @endif

                    </ul>
                    @if (!Auth::user())
                    <a class="btn btn-primary ms-lg-3" href="{{ route('register') }}">Register</a>
                    @endif
                </div>
            </div>
        </nav>


        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="butterup-main/butterup.min.js"> </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session()->has('message'))
            butterup.toast({
                title: 'Success',
                message: '{{ session()->get('message') }}',
                type:'success',
                icon: true,
                dismissable: true,
            });
        @endif
        
    });

    </script>
    <script src="resources/js/app.js"></script>


</body>

</html>