<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
    <style>
        *{
            margin:0;
            padding:0;
        }
    </style>
    <title>Document</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg .navbar-light bg-light">
      <a class="navbar-brand" href="#">Restoran Laravel</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item mr-1">
              <a class="nav-link btn btn-danger" href="{{ route('register') }}">Register</a>
          </li>
          <li class="nav-item">
              <a class="nav-link btn btn-primary" href="{{ route('login') }}">Login</a>
          </li>
        </ul>
        {{-- <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form> --}}
      </div>
    </nav>
    <div class="container-fluid mt-2 content">
      @yield('content');    
    </div>
</body>
</html>