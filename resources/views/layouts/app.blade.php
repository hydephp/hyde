<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>HydePHP</title>

    @include('layouts.meta') 
</head>
<body id="app" class="">
    @include('layouts.navigation') 

    <section id="content">
        @yield('content') 
    </section>

    @include('layouts.footer') 
</body>
</html>
