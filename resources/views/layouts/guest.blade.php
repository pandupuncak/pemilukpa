<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="description" content="{{ config('app.description', 'e-Voting Application') }}">
        <title>{{ config('app.name', 'e-Voting App') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Livvic:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.0/dist/alpine.js" defer></script>
    </head>
    <body>
        <style>
            @font-face {
                font-family: 'Florencesans';
                src: url('/fonts/Florencesans/Florsn01.ttf');
            }

            .font-florencesans {
                font-family: 'Florencesans', sans-serif;
                text-transform: uppercase;
            }

            .font-livvic {
                font-family: 'Livvic', sans-serif;
            }

            #mylayout {
                background-color: #f8fafc;
            }

            #low-el {
                width: 100vw;
                position: fixed;
                bottom: 0;
                z-index: 0;
            }

            #low-el img {
                width: 100vw;
            }

            .mymain {
                position: relative;
                z-index: 2;
            }
        </style>
        <div class="font-livvic text-gray-900 antialiased">
            {{ $slot }}
        </div>
    </body>
</html>
