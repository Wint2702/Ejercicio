@php
    
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel=icon href='{{{ asset('img/favicon.png') }}}' sizes="any" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{config('app.name')}}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://bootswatch.com/4/lux/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2020.3.1021/styles/kendo.common.min.css" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2020.3.1021/styles/kendo.bootstrap.min.css" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    @yield('css')

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary" style="border-radius: 0px!important">
            <a class="navbar-brand py-0" href="/">
                <img src="https://www.vybroo.com/content/images/logo_white.png" alt="logo cool" style="height: 50px">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          
            <div class="collapse navbar-collapse" id="navbarColor01">
              <ul class="navbar-nav mr-auto">
                @guest
                <li class="nav-item"><a class="nav-link" href="/" style="font-size: 1.4em">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}" style="color: white; font-size: 1.4em">Inicio de sesión</a></li>
                {{-- <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li> --}}

                @else
                <li class="nav-item active">
                  <a class="nav-link" href="#" style="font-size: 1.4em" >Registro de prospectos
                    <span class="sr-only">(current)</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#" style="font-size: 1.4em">Evaluar prospectos</a>
                </li>
                <li class="nav-item dropdown d-block float-right">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" style="font-size: 1.4em">{{ Auth::user()->name }}</a>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar sesión</a>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
                @endguest
              </ul>

            </div>
          </nav>

        <div class="principal container-fluid p-4">
            @yield('content')
        </div>

        @yield('modals')

        {{-- jQuery --}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" crossorigin="anonymous"></script>
        {{-- <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
        <script src="https://kendo.cdn.telerik.com/2020.3.1021/js/kendo.all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/autonumeric@4.5.10/dist/autoNumeric.min.js" integrity="sha256-84KcVmWpZ1CrMS/+FNQXXyLY+XN3PVgZYKfMfCXwMlg=" crossorigin="anonymous"></script>
        @yield('js')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
