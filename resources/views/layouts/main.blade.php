<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="butterup-main/butterup.min.css">


</head>

<body>
    @include('navbar')
    <!-- This includes the navigation bar template -->

    <div class="container">
        @yield('content')
        <!-- This is where individual view content will be inserted -->
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
</body>

</html>