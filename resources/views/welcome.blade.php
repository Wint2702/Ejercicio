<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Prospectos Vybroo</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: rgb(0, 0, 0);
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}" style="color: white">Continuar >></a>
                    @else
                        <a href="{{ route('login') }}" style="color: white">Iniciar sesión</a>
                        {{-- <a href="{{ route('register') }}">Register</a> --}}
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    <a class="" href="/">
                        <img src="https://www.vybroo.com/content/images/logo_white.png" alt="logo cool" style="">
                    </a>
                </div>

                <div class="links">
                    <a href="https://www.vybroo.com/corporativo" style="color: rgb(0, 189, 189)">Corporativo</a>
                    <a href="https://www.vybroo.com/punto_de_venta" style="color: red">Punto de venta</a>
                    <a href="https://www.vybroo.com/educativo" style="color: orange">Educativo</a>
                    <a href="https://www.vybroo.com/estacion" style="color: rgb(110, 0, 110)">Estación</a>
                    <a href="https://www.vybroo.com/podcast" style="color: grey">Podcast</a>
                </div>
            </div>
        </div>
    </body>
</html>
