<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{!! csrf_token() !!}">
    <title>dCars - B2B NFT Marketplace for Cars.</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/web3/3.0.0-rc.5/web3.min.js"></script>
    <script src="{!! asset('js/ethjs-unit.min.js') !!}"></script>
    <script src="{!! asset('js/app.js') !!}"></script>
    <style>
        .bs-example{
            margin: 20px;
        }
    </style>
</head>
<body>
<div class="bs-example">
    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <a href="#" class="navbar-brand"><img width="150" height="100" src="{!! asset('logo.png') !!}" alt="dCars"></a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav">
                <a href="#" class="nav-item nav-link active">Home</a>
                <a href="#" class="nav-item nav-link">Browse Cars</a>
            </div>
            @guest
                <div class="navbar-nav ml-auto">
                    <a href="{!! route('register') !!}" class="nav-item nav-link">Register</a>
                    <a href="{!! route('login') !!}" class="nav-item nav-link">Login</a>
                </div>
            @else
                <div class="navbar-nav ml-auto">
                    <button id="enableMetamask" class="btn btn-primary">Connect with Metamask</button>
                    <a href="{!! route('addCar1') !!}" class="nav-item nav-link">Add Car</a>
                    <a href="{!! route('user_dashboard') !!}" class="nav-item nav-link">Dashboard</a>
                </div>
            @endguest

        </div>
    </nav>
</div>
<div class="container">
    @yield('content')
</div>
</body>
</html>