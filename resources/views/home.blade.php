<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-token" content="{{ auth()->check() ? auth()->user()->api_token: '' }}">
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Document</title>
</head>
<style>
    .choose_file {
    position: relative;
    display: inline-block;   
    font: normal 14px Myriad Pro, Verdana, Geneva, sans-serif;
    color: #7f7f7f;
    margin-top: 2px;
    background: white
    }
    .choose_file input[type="file"]{
        -webkit-appearance:none; 
        position:absolute;
        top:0;
        left:0;
        opacity:0;
        width: 100%;
        height: 100%;
    }
</style>
<body>
    <div id="app">
        @include('partial.header')

        {{-- main --}}
        
            <router-view></router-view>
        
        {{-- end main --}}
    </div>
</body>
</html>