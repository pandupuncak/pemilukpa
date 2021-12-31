<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <div>
            Halo Pemilih Pemilu Panpel 49!<br><br>

            Terima kasih atas pemberian suara pada MPS. Suara atas nama <b>{{$name}}</b>, <b>{{$nim}}</b>, telah digunakan pada MPS pada <b>{{$time}}</b>.
            Jika merasa belum atau tidak memberikan suara segera hubungi cp (idline: cp) untuk pelaporan hal ini. <br><br>

            Terima kasih! Mohon untuk tidak membalas email ini.
        </div>
    </body>
</html>
