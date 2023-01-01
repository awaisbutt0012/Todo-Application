<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

      <link rel="stylesheet" href="{{asset('css/app.css')}}">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body>
   
        <div class="container w-50">
        @include('layouts.navigation')

@yield('content')
            <div class="row">
                <div class="col-md-12" id="app">
               
                    <list /> 

                </div>
            </div>
           
        </div>
       
    </body>
</html>
<script src="{{mix('js/app.js')}}"></script>
