<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <div>
            Halo,<br><br>

            Berikut adalah NIM dan password yang dapat Anda gunakan untuk login ke aplikasi {{ env('APP_NAME') }}, bagi Awi, Caya, Lume mohon menggunakan NIM jurusan. Bagi Artyakara, mohon menggunakan NIM TPB. <br>
            NIM: <b>NIM_Anda</b><br>
            Password: <b>{{ $password }}</b><br><br>

            *
            Mohon untuk tidak membalas email ini. Terima kasih.
        </div>
    </body>
</html>
