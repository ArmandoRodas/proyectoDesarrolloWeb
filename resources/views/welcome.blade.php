<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    <style>
        html, body {
            background-image: url('{{ asset('images/background.png') }}'); /* Ruta a la imagen en public/images */
            background-size: cover;
            background-position: center;
            color: #fff;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .links {
            display: flex;
            gap: 20px;
        }
        .links > a {
            color: #ffffff;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            text-transform: uppercase;
            transition: background-color 0.3s;
        }
        .links > a:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }
    </style>
</head>
<body>
    <h1>Bienvenido a {{ config('app.name', 'Tu Ecommerce e Inventario') }}</h1>
    <div class="links">
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/home') }}">Home</a>
            @else
                <a href="{{ route('login') }}">Iniciar Sesión</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Registrarse</a>
                @endif
            @endauth
        @endif
    </div>
</body>
</html>
